<?php namespace AlistairShaw\YewCMS\App\Http\Controllers\Api;

use AlistairShaw\YewCMS\App\Base\Exceptions\InvalidSearchParameterException;
use AlistairShaw\YewCMS\App\Base\ValueObjects\String\Password;
use AlistairShaw\YewCMS\App\Entities\User\UserFactory;
use AlistairShaw\YewCMS\App\Entities\User\UserRepository;
use AlistairShaw\YewCMS\App\Http\Requests\UserRequest;
use Request;

class UserController extends ApiBaseController {

    /**
     * Return list of users
     *
     * @param UserRepository $userRepository
     * @return array
     */
    public function index(UserRepository $userRepository)
    {
        try
        {
            return $this->apiRespond(true, $userRepository->search(Request::all(), Request::input('offset', 0), Request::input('limit', 10)));
        }
        catch (InvalidSearchParameterException $e)
        {
            return $this->apiRespond(false, [], $e->getMessage());
        }
    }

    /**
     * Store a new user
     *
     * @param UserRequest    $userRequest
     * @param UserRepository $userRepository
     * @return array
     */
    public function store(UserRequest $userRequest, UserRepository $userRepository)
    {
        $userFactory = new UserFactory();
        try
        {
            $vars = Request::all();
            $vars['password'] = Password::fromPlainText($vars['password']);

            $user = $userFactory->create($vars);
            $user = $userRepository->save($user);
        }
        catch (\Exception $e)
        {
            return $this->apiRespond(false, [], $e->getMessage());
        }

        return $this->apiRespond(true, $user->toOutput());
    }

    /**
     * @param  int           $id
     * @param UserRequest    $userRequest
     * @param UserRepository $userRepository
     * @return array
     */
    public function show($id, UserRequest $userRequest, UserRepository $userRepository)
    {
        try
        {
            $user = $userRepository->find($id);
        }
        catch (\Exception $e)
        {
            return $this->apiRespond(false, [], $e->getMessage());
        }

        return $this->apiRespond(true, $user->toOutput());
    }

    /**
     * @param  int           $id
     * @param UserRequest    $userRequest
     * @param UserRepository $userRepository
     * @return array
     */
    public function update($id, UserRequest $userRequest, UserRepository $userRepository)
    {
        try
        {
            // load user
            $user = $userRepository->find($id);

            // update user and save changes
            $userFactory = new UserFactory();
            $newData = Request::all();
            $user = $userFactory->update($user, $newData);

            $userRepository->save($user);
        }
        catch (\Exception $e)
        {
            return $this->apiRespond(false, [], $e->getMessage());
        }

        return $this->apiRespond(true, $user->toOutput());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int           $id
     * @param UserRequest    $userRequest
     * @param UserRepository $userRepository
     * @return array
     */
    public function destroy($id, UserRequest $userRequest, UserRepository $userRepository)
    {
        try
        {
            $user = $userRepository->find($id);
            $success = $user ? $userRepository->destroy($user->id) : false;
        }
        catch (\Exception $e)
        {
            return $this->apiRespond(false, [], $e->getMessage());
        }

        return $this->apiRespond((bool)$success);
    }
}