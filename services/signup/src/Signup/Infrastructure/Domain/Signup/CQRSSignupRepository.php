<?php
declare(strict_types=1);

namespace Infrastructure\Domain\Signup;

use Repository\CQRSRepository;
use Signup\Signup;
use Signup\SignupRepository;
use Signup\SignupNotFoundException;

class CQRSSignupRepository extends CQRSRepository implements SignupRepository
{
	const ENTITY_CLASS = Signup::class;

	public function add(Signup $signup): void
	{
		$this->saveAggregateRoot($signup);
	}

	public function getByID($id): Signup
	{
		if ($signup = $this->getAggregateRoot($id)) {
			return $signup;
		}

		throw new SignupNotFoundException();
	}

	public function save(Signup $signup): void
	{
		$this->saveAggregateRoot($signup);
	}
}
