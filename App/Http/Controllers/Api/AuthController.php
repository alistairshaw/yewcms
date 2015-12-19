<?php namespace AlistairShaw\YewCMS\App\Http\Controllers\Api;

use AlistairShaw\YewCMS\App\Base\ValueObjects\String\AuthToken;
use AlistairShaw\YewCMS\App\Base\ValueObjects\Web\EmailAddress;
use AlistairShaw\YewCMS\App\Entities\User\User;
use AlistairShaw\YewCMS\App\Entities\User\UserRepository;
use Request;

class AuthController extends ApiBaseController {

	/**
	 * @param UserRepository $userRepository
	 * @return User
	 */
	public function login(UserRepository $userRepository)
	{
		return $this->apiRespond(true, $this->userAuth->authenticatePassword($userRepository, EmailAddress::fromNative(Request::Input('email')), Request::Input('password'))->toOutput(['authToken']));
	}

	/**
	 * @param UserRepository $userRepository
	 * @return mixed
	 */
	public Function logout(UserRepository $userRepository)
	{
		return $this->apiRespond($this->userAuth->invalidateToken($userRepository, AuthToken::fromNative(Request::header('password'))));
	}

	/**
	 * This can be used to confirm if a token is valid
	 * @param UserRepository $userRepository
	 * @return array
	 */
	public function confirm(UserRepository $userRepository)
	{
        // NOTE: The username is this hash of the auth token plus the email address
        // dd(sha1(Request::header('username') . Request::header('password')));

		return $this->apiRespond(true, $this->userAuth->authenticateToken($userRepository, Request::header('username'), AuthToken::fromNative(Request::header('password')))->toOutput(['authToken']));
	}

}