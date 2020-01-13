<?php
declare(strict_types=1);

namespace Signup;

use Prooph\EventSourcing\AggregateChanged;

class SignupAddedEvent extends AggregateChanged
{
	/**
	 * @return string
	 */
	public function getFirstName(): string
	{
		return $this->payload['firstName'];
	}

	/**
	 * @return string
	 */
	public function getLastName(): string
	{
		return $this->payload['lastName'];
	}

	/**
	 * @return string
	 */
	public function getEmailAddress(): string
	{
		return $this->payload['emailAddress'];
	}

	/**
	 * @return Signup
	 */
	public function getSignup(): Signup
	{
		return $this->payload['signup'];
	}
}
