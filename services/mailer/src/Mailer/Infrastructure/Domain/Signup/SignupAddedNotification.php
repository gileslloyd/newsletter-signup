<?php
declare(strict_types=1);

namespace Infrastructure\Domain\Signup;

use Email\MailTransportFactory;

class SignupAddedNotification
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
	 * @var \Configuration
	 */
	private $config;

	public function __construct(string $firstName, string $lastName, string $emailAddress)
	{
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->emailAddress = $emailAddress;

		$this->config = new \Configuration('mailers');
	}

	public function send()
	{
		$mailer = new \Swift_Mailer(MailTransportFactory::instance()->smtp());

		$message = (new \Swift_Message())
			->setSubject($this->config->get('user.welcome.subject', 'Thanks for signing up'))
			->setFrom($this->config->get('from_address'))
			->setTo([$this->emailAddress => $this->getDisplayName()])
			->setBody(
				$this->getBody(),
				'text/html'
			);

		$mailer->send($message);
	}

	private function getDisplayName(): string
	{
		return trim(
			sprintf('%s %s', $this->firstName, $this->lastName)
		);
	}

	private function getBody(): \View
	{
		return new \View(
			'signup/welcome.php', [
				'displayName' => $this->getDisplayName(),
			]
		);
	}
}