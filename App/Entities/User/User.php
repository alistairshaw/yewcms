<?php namespace AlistairShaw\YewCMS\App\Entities\User;

use AlistairShaw\YewCMS\App\Base\Entity\AbstractEntity;
use AlistairShaw\YewCMS\App\Base\Entity\Entity;
use AlistairShaw\YewCMS\App\Base\ValueObjects\DateTime\DateTime;
use AlistairShaw\YewCMS\App\Base\ValueObjects\String\AuthToken;
use AlistairShaw\YewCMS\App\Base\ValueObjects\String\Password;
use AlistairShaw\YewCMS\App\Base\ValueObjects\Web\EmailAddress;

class User extends AbstractEntity implements Entity {

	/**
	 * @var array
	 */
	protected $outputtable = ['name', 'email'];

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var EmailAddress
	 */
	protected $email;

	/**
	 * @var Password
	 */
	protected $password;

	/**
	 * @var AuthToken
	 */
	protected $authToken;

	/**
	 * @var DateTime
	 */
	protected $authTokenExpires;

	/**
	 * @return string
	 */
	public function name()
	{
		return $this->name;
	}

	/**
	 * @param EmailAddress $email
	 */
	public function setEmail(EmailAddress $email)
	{
		$this->email = $email;
	}

	/**
	 * @return string
	 */
	public function email()
	{
		return $this->email;
	}

	/**
	 * @param Password $password
	 */
	public function setPassword(Password $password)
	{
		$this->password = $password;
	}

	/**
	 * @return Password
	 */
	public function password()
	{
		return $this->password;
	}

	/**
	 * @param AuthToken $authToken
	 */
	public function setAuthToken(AuthToken $authToken)
	{
		$this->authToken = $authToken;
	}

	/**
	 * @return AuthToken
	 */
	public function authToken()
	{
		return $this->authToken;
	}

	/**
	 * @param DateTime $authTokenExpires
	 */
	public function setAuthTokenExpires(DateTime $authTokenExpires)
	{
		$this->authTokenExpires = $authTokenExpires;
	}

	/**
	 * @return DateTime
	 */
	public function authTokenExpires()
	{
		return $this->authTokenExpires;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return (string)$this->id();
	}
}