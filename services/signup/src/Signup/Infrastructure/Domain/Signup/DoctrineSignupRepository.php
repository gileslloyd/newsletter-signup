<?php
declare(strict_types=1);

namespace Infrastructure\Domain\Signup;

use Domain\Event\DomainEventListener;
use Repository\DoctrineRepository;
use Signup\Signup;
use Signup\SignupAddedEvent;
use Signup\SignupNotFoundException;
use Signup\SignupRepository;

class DoctrineSignupRepository extends DoctrineRepository implements DomainEventListener, SignupRepository
{
	const ENTITY_CLASS = Signup::class;

	/**
	 * @param SignupAddedEvent $event
	 */
	public function handle($event)
	{
		switch (get_class($event)) {
			case SignupAddedEvent::class:
				$this->add($event->getSignup());
				break;
			default:
				$this->saveChanges();
		}
	}

	public function add(Signup $user): void
	{
		$this->saveNewModelToDB($user);
	}

	public function save(Signup $user): void
	{
		$this->saveChanges();
	}

	public function getByID($id): Signup
	{
		if ($signup = $this->getEntityByID(static::ENTITY_CLASS, $id)) {
			return $signup;
		}

		throw new SignupNotFoundException();
	}
}
