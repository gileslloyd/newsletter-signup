<?php

return [
	\Signup\SignupAddedEvent::class => ['read_signup_repository', 'signup_added_notifier'],
];
