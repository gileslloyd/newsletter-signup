<?php
declare(strict_types=1);

namespace Signup;

use Application\Signup\SignupValidationService;

class AddSignupService
{
	/**
	 * @var SignupRepository
	 */
	private $readRepo;

	/**
	 * @var SignupRepository
	 */
	private $writeRepo;

	/**
	 * @var SignupValidationService
	 */
	private $validationService;

	public function __construct(
		SignupReadRepository $readSignupRepository,
		SignupRepository $writeSignupRepository,
		SignupValidationService $validationService
	) {
		$this->readRepo = $readSignupRepository;
		$this->writeRepo = $writeSignupRepository;
		$this->validationService = $validationService;
	}

	public function handle(AddSignupRequest $request): SignupResponse
	{
		$this->validateRequest($request);

		$signup = $this->createSignup($request);
		$this->writeRepo->add($signup);

		return $this->createResponse($signup);
	}

	private function validateRequest(AddSignupRequest $request)
	{
		$this->validationService->validateSignupRequest($request);

		if ($this->emailIsDuplicate($request->getEmailAddress())) {
			throw new DuplicateSignupException();
		}
	}

	private function emailIsDuplicate(string $emailAddress): bool
	{
		try {
			$this->readRepo->getByEmailAddress($emailAddress);

			// Getting here means that a signup was found with that email
			return true;
		} catch (SignupNotFoundException $e) {
			return false;
		}
	}

	private function createSignup(AddSignupRequest $request): Signup
	{
		return Signup::factory(
			$request->getFirstName(),
			$request->getLastName(),
			$request->getEmailAddress()
		);
	}

	private function createResponse(Signup $signup): SignupResponse
	{
		return new SignupResponse(
			$signup->getID(),
			$signup->getFirstName(),
			$signup->getLastName(),
			$signup->getEmailAddress()
		);
	}
}
