<?php
declare(strict_types=1);

namespace App\Message;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Message\MessagePayload;

class MessageBus
{
    /**
     * @var string
     */
    private $host;

    /**
     * Curl
     */
    private $apiClient;

    /**
     * @var AMQPStreamConnection
     */
    private $connection;

    /**
     * @var \PhpAmqpLib\Channel\AMQPChannel
     */
    private $channel;

    /**
     * @var string|null
     */
    private $correlation_id = null;

    /**
     * @var array|null
     */
    private $response = null;

    /**
     * @var array
     */
    private $gathered = [];

    public function __construct(array $config)
    {
        $this->host = $config['host'];
        $this->apiClient = $this->getApiClient(
            $config['user'],
            $config['password']
        );

        $this->connection = new AMQPStreamConnection(
            $config['host'],
            $config['port'],
            $config['user'],
            $config['password']
        );

        $this->channel = $this->connection->channel();
    }

    public function async(string $queue, array $message): void
    {
        $this->channel->queue_declare($queue, false, false, false, false);

        $this->channel->basic_publish(new AMQPMessage(json_encode($message)), '', $queue);
    }

    public function sync(string $queue, array $message): MessagePayload
    {
        $this->response = null;
        $this->correlation_id = uniqid();

        list($callback_queue, ,) = $this->channel->queue_declare("", false, false, true, false);
        $this->channel->basic_consume($callback_queue, '', false, false, false, false, [$this, 'onResponse']);

        $this->channel->basic_publish(
            new AMQPMessage(
                json_encode($message),
                ['correlation_id' => $this->correlation_id, 'reply_to' => $callback_queue]
            ),
            '',
            $queue
        );

        while(!$this->response) {
            $this->channel->wait();
        }

        return new MessagePayload($this->response);
    }

    public function publish(string $exchange, array $message)
    {
        $this->channel->exchange_declare(
            $exchange,
            'fanout',
            false,
            false,
            false
        );

        $this->channel->basic_publish(new AMQPMessage(json_encode($message)), $exchange);
    }

    public function scatter(string $exchange, string $routingKey, array $message): MessagePayload
    {
        $this->gathered = [];
        $this->correlation_id = uniqid();

        $this->channel->exchange_declare($exchange, 'fanout', false, false, false);

        list($callback_queue, ,) = $this->channel->queue_declare("", false, false, true, false);
        $this->channel->basic_consume($callback_queue, '', false, false, false, false, [$this, 'onGatherResponse']);

        $this->channel->basic_publish(
            new AMQPMessage(
                json_encode($message),
                ['correlation_id' => $this->correlation_id, 'reply_to' => $callback_queue]
            ),
            $exchange,
            $routingKey
        );

        $startTime = time();
        $expectedResponses = $this->getExpectedResponses($exchange, $routingKey);
        while(count($this->gathered) < $expectedResponses) {
            try {
                $this->channel->wait(null, false, 2); // Wait 2 seconds max for responses
            } catch (\PhpAmqpLib\Exception\AMQPTimeoutException $e) {
                // We set the timeout so we don't care about this
            }

            if ((time() - $startTime) >= 2) { // Wait 2 seconds max for responses
                break;
            }
        }

        return (new MessagePayloadFactory())->fromScatterGather($this->gathered);
    }

    private function getApiClient(string $userName, string $password)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERPWD, $userName . ":" . $password);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return $ch;
    }

    private function getExpectedResponses(string $exchange, string $routingKey): int
    {
        $expectedResponses = 0;

        curl_setopt($this->apiClient, CURLOPT_URL, "http://{$this->host}:15672/api/exchanges/%2F/{$exchange}/bindings/source");
        $return = curl_exec($this->apiClient);

        if ($listeners = json_decode($return, true)) {
            foreach ($listeners as $listener) {
                if ($listener['routing_key'] === $routingKey) {
                    $expectedResponses++;
                }
            }
        }

        return $expectedResponses;
    }

    public function onResponse(AMQPMessage $response) {
        if($response->get('correlation_id') == $this->correlation_id) {
            $response = json_decode($response->body, true);
            $this->response = $response['payload'] ?? $response;
        }
    }

    public function onGatherResponse(AMQPMessage $response) {
        if($response->get('correlation_id') == $this->correlation_id) {
            $response = json_decode($response->body, true);
            $this->gathered[] = $response['payload'] ?? $response;
        }
    }

    public function __destruct()
    {
        $this->connection->close();
        curl_close($this->apiClient);
    }
}
