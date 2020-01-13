<?php

return [
	'message_bus' => [
		Message\MessageBus::class,
		[
			new Configuration('rabbit'),
		],
		\DI\InjectionType::SHARED
	],
	'write_signup_repository' => [
		Infrastructure\Domain\Signup\CQRSSignupRepository::class,
		[
			Domain\Event\EventBus::getEventStore(),
			ES\SnapshotStore::instance(),
		],
		\DI\InjectionType::SHARED
	],
	'read_signup_repository' => [
		Infrastructure\Domain\Signup\DoctrineSignupRepository::class,
		[],
		\DI\InjectionType::SHARED
	],
	'add_signup_service' => [
		Signup\AddSignupService::class,
		[
			'read_signup_repository',
			'write_signup_repository',
			new \Application\Signup\SignupValidationService(),
		]
	],
	'signup_added_notifier' => [
		\Infrastructure\Domain\Signup\SignupAddedNotifier::class,
		[
			'message_bus',
		]
	]
];
