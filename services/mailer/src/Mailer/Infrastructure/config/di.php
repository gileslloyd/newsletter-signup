<?php

return [
	'message_bus' => [
		Message\MessageBus::class,
		[
			new Configuration('rabbit'),
		],
		\DI\InjectionType::SHARED
	],
];
