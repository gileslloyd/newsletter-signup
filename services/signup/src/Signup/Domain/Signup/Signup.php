<?php
declare(strict_types=1);

namespace Signup;

class Signup extends \ES\AggregateRoot
{
	/**
	 * @var string
	 */
	private $firstName;

	/**
	 * @var string
	 */
	private $lastName;

	/**
	 * @var string
	 */
	private $emailAddress;

	public static function factory(string $firstName, string $lastName, string $emailAddress): Signup
	{
		$signup = new Signup();

		$signup->recordThat(
			SignupAddedEvent::occur($signup->getID(), [
				'firstName' => $firstName,
				'lastName' => $lastName,
				'emailAddress' => $emailAddress,
				'signup' => $signup,
			])
		);


		return $signup;
	}

	/**
	 * @return string
	 */
	public function getFirstName(): string
	{
		return $this->firstName;
	}

	/**
	 * @return string
	 */
	public function getLastName(): string
	{
		return $this->lastName;
	}

	/**
	 * @return string
	 */
	public function getEmailAddress(): string
	{
		return $this->emailAddress;
	}
}
