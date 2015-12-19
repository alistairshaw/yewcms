<?php namespace AlistairShaw\YewCMS\App\Entities\User;

use AlistairShaw\YewCMS\App\Base\Entity\AbstractEntityFactory;
use AlistairShaw\YewCMS\App\Base\Entity\EntityFactory;

class UserFactory extends AbstractEntityFactory implements EntityFactory {

	/**
	 * @var string
	 */
	protected $entityClassName = 'AlistairShaw\YewCMS\App\Entities\User\User';

	/**
	 * @var array
	 */
	protected $valueObjectAssociations = [
		'email'            => 'AlistairShaw\YewCMS\App\Base\ValueObjects\Web\EmailAddress',
		'password'         => 'AlistairShaw\YewCMS\App\Base\ValueObjects\String\Password',
		'createdAt'        => 'AlistairShaw\YewCMS\App\Base\ValueObjects\DateTime\DateTime',
		'updatedAt'        => 'AlistairShaw\YewCMS\App\Base\ValueObjects\DateTime\DateTime',
		'authToken'        => 'AlistairShaw\YewCMS\App\Base\ValueObjects\String\AuthToken',
		'authTokenExpires' => 'AlistairShaw\YewCMS\App\Base\ValueObjects\DateTime\DateTime'
	];

}