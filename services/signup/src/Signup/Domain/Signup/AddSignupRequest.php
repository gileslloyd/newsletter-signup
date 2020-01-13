<?php
declare(strict_types=1);

namespace Signup;

class AddSignupRequest
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

	/**
	 * @var string
	 */
	private $emailConfirmation;

	public function __construct(
		string $firstName,
		string $lastName,
		string $emailAddress,
		string $emailConfirmation
	) {
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->emailAddress = $emailAddress;
		$this->emailConfirmation = $emailConfirmation;
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

	/**
	 * @return string
	 */
	public function getEmailConfirmation(): string
	{
		return $this->emailConfirmation;
	}

	public function toArray(): array
	{
		return get_object_vars($this);
	}
}
