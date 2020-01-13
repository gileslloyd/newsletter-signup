<?php
declare(strict_types=1);

namespace Controller;

use Application\Signup\ValidationFailedException;
use Message\MessagePayload;
use Signup\AddSignupRequest;
use Signup\DuplicateSignupException;

class AddSignupController extends \Controller
{
	public function execute(MessagePayload $payload)
	{
		try {
			$response = $this->command_bus->handle(
				new AddSignupRequest(
					$payload->get('first_name', ''),
					$payload->get('surname', ''),
					$payload->get('email_address', ''),
					$payload->get('confirm_email', '')
				)
			);

			return ['success' => true, 'id' => $response->getID()];
		} catch (ValidationFailedException $e) {
			return ['success' => false, 'error' => $e->getMessage(), 'code' => 400];
		} catch (DuplicateSignupException $e) {
			return ['success' => false, 'error' => $e->getMessage(), 'code' => 409];
		} catch (\Exception $e) {
			return ['success' => false, 'error' => $e->getMessage()];
		}
	}
}
