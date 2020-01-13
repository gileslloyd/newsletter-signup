<?php
namespace Signup;

interface SignupRepository
{
	public function add(Signup $user): void;

	public function getByID($id): Signup;

	public function save(Signup $user): void;
}
