<?php namespace AlistairShaw\YewCMS\App\Base\Services\UserAuth;

use AlistairShaw\YewCMS\App\Base\ValueObjects\String\AuthToken;
use AlistairShaw\YewCMS\App\Base\ValueObjects\Web\EmailAddress;
use AlistairShaw\YewCMS\App\Entities\User\User;
use AlistairShaw\YewCMS\App\Entities\User\UserRepository;

interface UserAuth {

	/**
	 * @param UserRepository $userRepository
	 * @param EmailAddress   $emailAddress
	 * @param string         $plainPassword
	 * @return User
	 */
	public function authenticatePassword(UserRepository $userRepository, EmailAddress $emailAddress, $plainPassword);

	/**
	 * @param UserRepository $userRepository
	 * @param string         $username
	 * @param AuthToken      $authToken
	 * @return User
	 */
	public function authenticateToken(UserRepository $userRepository, $username, AuthToken $authToken);

	/**
	 * @param UserRepository $userRepository
	 * @param AuthToken      $authToken
	 * @return mixed
	 */
	public function invalidateToken(UserRepository $userRepository, AuthToken $authToken);

	/**
	 * @return User
	 */
	public function getUser();

}