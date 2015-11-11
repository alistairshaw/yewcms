<?php namespace AlistairShaw\YewCMS\App\Http\Controllers\Api;

use App\ThisIsValeting\Base\Services\UserAuth\UserAuth;
use App\ThisIsValeting\Base\ValueObjects\String\AuthToken;
use App\ThisIsValeting\Base\ValueObjects\Web\EmailAddress;
use App\ThisIsValeting\User\UserRepository;
use Request;

class AuthController extends ApiBaseController {

	/**
	 * @param UserRepository $userRepository
	 * @return \App\ThisIsValeting\User\User
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
		return $this->apiRespond(true, $this->userAuth->authenticateToken($userRepository, Request::header('username'), AuthToken::fromNative(Request::header('password')))->toOutput(['authToken']));
	}

}