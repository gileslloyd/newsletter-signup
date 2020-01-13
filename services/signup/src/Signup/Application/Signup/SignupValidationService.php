<?php
declare(strict_types=1);

namespace Application\Signup;

use Signup\AddSignupRequest;

class SignupValidationService
{
	public function validateSignupRequest(AddSignupRequest $request)
	{
		$this->checkForRequiredFields($request)
			->checkEmailsMatch($request)
			->checkEmailAddressIsValid($request);
	}

	private function checkForRequiredFields(AddSignupRequest $request): SignupValidationService
	{
		$missing_fields = [];

		// All fields are required so just check they have a value
		foreach ($request->toArray() as $field => $value) {
			if (empty($value)) {
				$missing_fields[] = $field;
			}
		}

		if (!empty($missing_fields)) {
			throw new ValidationFailedException(
				sprintf("The following fields are required: %s", implode(", ", $missing_fields))
			);
		}

		return $this;
	}

	private function checkEmailsMatch(AddSignupRequest $request): SignupValidationService
	{
		if ($request->getEmailAddress() !== $request->getEmailConfirmation()) {
			throw new ValidationFailedException('Email addresses do not match. Please check and try again');
		}

		return $this;
	}

	private function checkEmailAddressIsValid(AddSignupRequest $request): SignupValidationService
	{
		if(!filter_var($request->getEmailAddress(),FILTER_VALIDATE_EMAIL)) {
			throw new ValidationFailedException('Email address is not valid. Please check and try again');
		}

		return $this;
	}
}
