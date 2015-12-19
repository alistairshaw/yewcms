<?php namespace AlistairShaw\YewCMS\App\Entities\User\Gateway;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentAuthTokenModel extends Model {

	use SoftDeletes;

	/**
	 * @var string
	 */
	protected $table = 'yew_auth_tokens';

	/**
	 * @var array
	 */
	protected $fillable = ['user_id', 'auth_token', 'auth_token_expires'];

    public function user()
    {
        return $this->belongsTo('AlistairShaw\YewCMS\App\Entities\User\Gateway\EloquentUserModel');
    }
}
