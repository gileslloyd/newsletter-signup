<?php
declare(strict_types=1);

namespace Infrastructure\Domain\Signup;

use Domain\Event\DomainEventListener;
use Message\MessageBus;
use Signup\SignupAddedEvent;

class SignupAddedNotifier implements DomainEventListener
{
	/**
	 * @var MessageBus
	 */
	private $messageBus;

	public function __construct(MessageBus $messageBus)
	{
		$this->messageBus = $messageBus;
	}

	/**
	 * @param SignupAddedEvent $event
	 */
	public function handle($event)
	{
		$this->messageBus->publish(
			'signup',
			[
				'role' => 'signup',
				'cmd' => 'added',
				'payload' => [
					'id' => $event->getSignup()->getID(),
					'first_name' => $event->getFirstName(),
					'last_name' => $event->getLastName(),
					'email_address' => $event->getEmailAddress(),
				],
			]
		);
	}
}
