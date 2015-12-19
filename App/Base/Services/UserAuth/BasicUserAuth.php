<?php namespace AlistairShaw\YewCMS\App\Base\Services\UserAuth;

use AlistairShaw\YewCMS\App\Base\ValueObjects\DateTime\DateTime;
use AlistairShaw\YewCMS\App\Base\ValueObjects\String\AuthToken;
use AlistairShaw\YewCMS\App\Base\ValueObjects\Web\EmailAddress;
use AlistairShaw\YewCMS\App\Entities\User\User;
use AlistairShaw\YewCMS\App\Entities\User\UserRepository;
use App;
use Config;
use Hash;
use Request;

class BasicUserAuth implements UserAuth {

    /**
     * @var int
     */
    private $tokenExpiryMinutes = 30;

    /**
     * @param UserRepository $userRepository
     * @param EmailAddress   $emailAddress
     * @param string         $plainPassword
     * @return User
     */
    public function authenticatePassword(UserRepository $userRepository, EmailAddress $emailAddress, $plainPassword)
    {
        // find user
        $user = $userRepository->findByEmail($emailAddress);
        if (!$user) abort(401, 'Authentication Failed');

        // check password hash
        if (!Hash::check($plainPassword, (string)$user->password())) abort(401, 'Authentication Failed');

        return $this->generateAuthToken($user, $userRepository);
    }

    /**
     * @param UserRepository $userRepository
     * @param string         $username
     * @param AuthToken      $authToken
     * @return User
     */
    public function authenticateToken(UserRepository $userRepository, $username, AuthToken $authToken)
    {
        $user = $this->checkForAuth($userRepository, $username, $authToken);
        if (!$user) abort(401, 'Invalid Authentication Token');

        return $user;
    }

    /**
     * @param UserRepository $userRepository
     * @param string         $username
     * @param AuthToken      $authToken
     * @return User
     */
    private function checkForAuth(UserRepository $userRepository, $username, AuthToken $authToken)
    {
        $user = $userRepository->findByAuthToken($authToken);
        if (!$user) return NULL;

        $hashedUsername = sha1($user->email . $authToken);
        if ($username !== $hashedUsername) return NULL;

        // extend token expiry
        $user->authTokenExpires = DateTime::fromString(date("Y-m-d H:i:s", strtotime("+1 day")));
        $userRepository->save($user);

        Config::set('user', $user);

        return $user;
    }

    /**
     * @param User           $user
     * @param UserRepository $userRepository
     * @return User
     */
    private function generateAuthToken(User $user, UserRepository $userRepository)
    {
        $isUnique = false;
        $token = new AuthToken();
        while (!$isUnique)
        {
            $token = new AuthToken();
            $userModel = $userRepository->findByAuthToken($token);
            if (!$userModel) $isUnique = true;
        }

        // save auth token for user
        $user = $userRepository->saveAuthToken($user, $token);

        return $user;
    }

    /**
     * @param UserRepository $userRepository
     * @param AuthToken      $authToken
     * @return mixed
     */
    public function invalidateToken(UserRepository $userRepository, AuthToken $authToken)
    {
        $user = $userRepository->findByAuthToken($authToken);
        if ($user)
        {
            unset($user->authToken);
            unset($user->authTokenExpires);

            $userRepository->save($user);
        }

        return true;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        $user = Config::get('user');
        if (!$user)
        {
            $user = $this->checkForAuth($this->resolveUserRepository(), Request::header('username'), AuthToken::fromNative(Request::header('password')));
        }

        return $user;
    }

    /**
     * @return UserRepository
     */
    private function resolveUserRepository()
    {
        return App::make('AlistairShaw\YewCMS\App\Entities\User\UserRepository');
    }

}