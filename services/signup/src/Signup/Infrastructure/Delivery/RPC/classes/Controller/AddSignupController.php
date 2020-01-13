<?php
declare(strict_types=1);

namespace Controller;

use Message\MessagePayload;
use Signup\AddSignupRequest;

class AddSignupController extends \Controller
{
	public function execute(MessagePayload $payload)
	{
		try {
			$response = $this->command_bus->handle(
				new AddSignupRequest(
					$payload->get('first_name'),
					$payload->get('surname'),
					$payload->get('email_address'),
					$payload->get('confirm_email')
				)
			);

			return ['success' => true, 'id' => $response->getID()];
		} catch (\Exception $e) {
			return ['success' => false, 'error' => $e->getMessage()];
		}
	}
}
