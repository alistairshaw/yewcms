<?php namespace AlistairShaw\YewCMS\App\Entities\User;

use AlistairShaw\YewCMS\App\Base\Repository\Repository;
use AlistairShaw\YewCMS\App\Base\ValueObjects\String\AuthToken;

interface UserRepository extends Repository {

	/**
	 * @param User $user
	 * @param AuthToken $token
	 * @return User
	 */
	public function saveAuthToken(User $user, AuthToken $token);

	/**
	 * @param string $token
	 * @return mixed
	 */
	public function findByAuthToken($token);

	/**
	 * @param string $email
	 * @return mixed
	 */
	public function findByEmail($email);
}