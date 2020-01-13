<?php
declare(strict_types=1);

namespace Controller;

use Infrastructure\Domain\Signup\SignupAddedNotification;
use Message\MessagePayload;

class SignupController extends \Controller
{
	public function welcome(MessagePayload $payload)
	{
		try {
			$mailer = new SignupAddedNotification(
				$payload->get('first_name'),
				$payload->get('last_name'),
				$payload->get('email_address')
			);

			$mailer->send();

			$this->write("Mailer Sent");
		} catch (\Exception $e) {
			$this->write($e->getMessage());
		}
	}
}
