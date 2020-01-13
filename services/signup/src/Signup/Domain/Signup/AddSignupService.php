<?php
declare(strict_types=1);

namespace Signup;

use Application\Signup\SignupValidationService;

class AddSignupService
{
	/**
	 * @var SignupRepository
	 */
	private $userRepository;

	/**
	 * @var SignupValidationService
	 */
	private $validationService;

	public function __construct(SignupRepository $userRepository, SignupValidationService $validationService)
	{
		$this->userRepository = $userRepository;
		$this->validationService = $validationService;
	}

	public function handle(AddSignupRequest $request): SignupResponse
	{
		$signup = $this->createSignup($request);
		$this->userRepository->add($signup);

		return $this->createResponse($signup);
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
