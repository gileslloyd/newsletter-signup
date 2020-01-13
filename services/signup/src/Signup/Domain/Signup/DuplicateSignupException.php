<?php
declare(strict_types=1);

namespace Signup;

class DuplicateSignupException extends \DomainException
{
	protected $message = 'This email address is already in use';
}
