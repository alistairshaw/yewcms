<?php namespace AlistairShaw\YewCMS\App\Entities\User\Repository;

use AlistairShaw\YewCMS\App\Base\Exceptions\DuplicateEmailAddressException;
use AlistairShaw\YewCMS\App\Base\Exceptions\InvalidIdException;
use AlistairShaw\YewCMS\App\Base\Repository\AbstractEloquentRepository;
use AlistairShaw\YewCMS\App\Base\ValueObjects\DateTime\DateTime;
use AlistairShaw\YewCMS\App\Base\ValueObjects\String\AuthToken;
use AlistairShaw\YewCMS\App\Entities\User\Gateway\EloquentAuthTokenModel;
use AlistairShaw\YewCMS\App\Entities\User\Gateway\EloquentUserModel;
use AlistairShaw\YewCMS\App\Entities\User\User;
use AlistairShaw\YewCMS\App\Entities\User\UserFactory;
use AlistairShaw\YewCMS\App\Entities\User\UserRepository;

class EloquentUserRepository extends AbstractEloquentRepository implements UserRepository {

	/**
	 * @var array
	 */
	protected $validSearchVariables = ['name', 'email'];

	/**
	 * @param EloquentUserModel $model
	 * @param UserFactory       $factory
	 */
	public function __construct(EloquentUserModel $model, UserFactory $factory)
	{
		$this->model   = $model;
		$this->factory = $factory;
	}

    /**
     * @param int $id
     * @return User
     * @throws InvalidIdException
     */
    public function find($id)
    {
        if ( ! (int) $id > 0)
        {
            throw new InvalidIdException($id);
        }

        if ($record = $this->model->find($id))
        {
            $record = $record->toArray();

            // get current auth token, if one exists
            $authToken = EloquentAuthTokenModel::where('user_id', $record['id'])->where('auth_token_expires', '>', date("Y-m-d H:i:s"))->first();
            $record['auth_token'] = $authToken->auth_token;
            $record['auth_token_expires'] = $authToken->auth_token_expires;

            return $this->factory->create($record);
        }

        return null;
    }

	/**
	 * @param User $user
	 * @return mixed
	 * @throws DuplicateEmailAddressException
	 */
	public function save($user)
	{
		// make sure there is no duplicate email
		if ($this->findByEmail($user->email, $user->id)) throw new DuplicateEmailAddressException($user->email);

        // if auth token exists, update the auth token expiry date in the db, otherwise delete all tokens
        if ($user->authToken)
        {
            $authToken = EloquentAuthTokenModel::where('auth_token', $user->authToken)->first();
            $authToken->auth_token_expires = $user->authTokenExpires;
            $authToken->save();
        }
        else
        {
            EloquentAuthTokenModel::where('user_id', $user->id)->delete();
        }

		return parent::save($user);
	}

	/**
	 * @param string $token
	 * @return User
	 */
	public function findByAuthToken($token)
	{
		$authModel = EloquentAuthTokenModel::where('auth_token', $token)->where('auth_token_expires', '>=', date("Y-m-d H:i:s"))->first();
		if ( ! $authModel) return null;

		return $this->find($authModel->user->id);
	}

	/**
	 * @param string $email
	 * @param null   $not
	 * @return mixed
	 */
	public function findByEmail($email, $not = null)
	{
		$model = new EloquentUserModel();
		$query = $model->where('id', '!=', 0);


		$query->where('email', $email);
		if ($not) $query->where('id', '!=', (int) $not);
		$user = $query->first();
		if ( ! $user) return null;

		return $this->find($user->id);
	}

    /**
     * @param User   $user
     * @param AuthToken $token
     * @return User
     */
    public function saveAuthToken(User $user, AuthToken $token)
    {
        // delete other tokens for this user
        $authTokenModel = new EloquentAuthTokenModel();
        $authTokenModel->where('user_id', $user->id)->delete();

        $expiryDate = DateTime::fromString(date("Y-m-d H:i:s", strtotime("+1 day")));

        if ($authTokenModel = $authTokenModel->create(['user_id' => $user->id, 'auth_token' => (string)$token, 'auth_token_expires' => (string)$expiryDate]))
        {
            $user->authToken = $token;
            $user->authTokenExpires = $expiryDate;

            $authTokenModel->save();
        }

        return $user;
    }
}