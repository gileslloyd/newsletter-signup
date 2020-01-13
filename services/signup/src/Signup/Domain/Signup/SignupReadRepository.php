<?php
namespace Signup;

interface SignupReadRepository
{
	public function getByEmailAddress($emailAddress): Signup;
}
