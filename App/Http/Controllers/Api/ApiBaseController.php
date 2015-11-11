<?php namespace AlistairShaw\YewCMS\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use AlistairShaw\YewCMS\App\Base\Services\ApiResponder\ApiResponder;
use App\ThisIsValeting\Base\Services\UserAuth\UserAuth;
use App\ThisIsValeting\User\User;
use App\ThisIsValeting\User\UserRepository;

class ApiBaseController extends Controller {

	/**
	 * @var UserAuth
	 */
	protected $userAuth;

	/**
	 * @var UserRepository
	 */
	protected $userRepository;

	/**
	 * @param UserAuth       $userAuth
	 * @param UserRepository $userRepository
	 */
	public function __construct(UserAuth $userAuth, UserRepository $userRepository)
	{
		$this->userAuth       = $userAuth;
		$this->userRepository = $userRepository;
	}

	/**
	 * @param boolean      $success
	 * @param array|object $data
	 * @param string       $message
	 * @return array
	 */
	protected function apiRespond($success, $data = [], $message = '')
	{
		return ApiResponder::respondAjax($success, $data, $message, true);
	}

	/**
	 * @return User
	 */
	protected function getLoggedInUser()
	{
		return $this->userAuth->getUser();
	}
}