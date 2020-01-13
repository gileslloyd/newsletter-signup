<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Message\MessageBus;
use Illuminate\Http\Response;

class Controller extends BaseController
{
    /**
     * @var MessageBus
     */
    protected $messageBus;

    public function __construct(MessageBus $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    protected function apiResponse(array $content, int $code): Response
    {
        return new Response(
            [
                'meta' => [
                    'code' => $code,
                ],
                'body' => $content,
            ],
            $code
        );
    }
}
