<?php namespace AlistairShaw\YewCMS\App\Entities\User\Gateway;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentUserModel extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * @var array
	 */
	protected $fillable = ['title', 'name', 'email', 'password', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
	public function auth_tokens()
	{
        return $this->hasMany('AlistairShaw\YewCMS\App\Entities\User\Gateway\EloquentAuthTokenModel');
	}
}
