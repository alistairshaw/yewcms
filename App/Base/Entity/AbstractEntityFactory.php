<?php namespace AlistairShaw\YewCMS\App\Base\Entity;

use AlistairShaw\YewCMS\App\Base\ValueObjects\DateTime\DateTime;
use AlistairShaw\YewCMS\App\Base\ValueObjects\String\Password;

abstract class AbstractEntityFactory implements EntityFactory {

	/**
	 * @var Entity
	 */
	protected $entity;

	/**
	 * @var string
	 */
	protected $entityClassName;

	/**
	 * @var array
	 */
	protected $valueObjectAssociations = [];

	/**
	 * Common for all (most) entities
	 * @param array $data
	 * @return Entity
	 */
	public function create($data = array())
	{
		$this->entity = new $this->entityClassName();

		$final = $this->processInput($data);

		foreach ($final as $key => $value)
		{
			// skip pivot, it's there if we pull in a relationship from Eloquent
			if ($key == 'pivot') continue;
			if ($value !== null) $this->entity->{$key} = $value;
		}

		// if dates are not set, set them to now
		if ( ! $this->entity->{'createdAt'}) $this->entity->{'createdAt'} = DateTime::now();
		if ( ! $this->entity->{'updatedAt'}) $this->entity->{'updatedAt'} = DateTime::now();

		return $this->entity;
	}

	/**
	 * Updates the parameters of an entity and then returns it
	 * @param Entity $entity
	 * @param array  $data
	 * @return Entity
	 */
	public function update(Entity $entity, $data = array())
	{
		$this->entity = $entity;
		$final        = $this->processInput($data, true);

		foreach ($final as $key => $value)
		{
			if ($value !== null)
			{
				$this->entity->{$key} = $value;
			}
		}

		return $this->entity;
	}

	/**
	 * Replace this function in the factory if you need to do special things
	 *    with any of the input fields (other than the timestamp dates, as those
	 *    are already dealt with)
	 * @param array $data
	 * @return array
	 */
	protected function processInput($data = array())
	{
		$final = [];
		foreach ($data as $key => $value)
		{
			$newKey           = camel_case($key);
			$final[ $newKey ] = $value;
		}

		foreach ($final as $key => $val)
		{
			if ($val !== null)
			{
				foreach ($this->valueObjectAssociations as $keyName => $className)
				{
					if ($key == $keyName && ! is_a($val, $className))
					{
						switch ($className)
						{
							// if it's a date or a datetime, then we need to create from date string
							case 'AlistairShaw\YewCMS\App\Base\ValueObjects\DateTime\DateTime':
							case 'AlistairShaw\YewCMS\App\Base\ValueObjects\DateTime\Date':
								$val = $className::fromString($val);
								break;
							// if it's a password, we need to check if it's already hashed
							case 'AlistairShaw\YewCMS\App\Base\ValueObjects\String\Password':
								$val = ($this->isHash($val)) ? Password::fromNative($val) : Password::fromPlainText($val);
								break;
							default:
								$val = new $className($val);
						}
					}
				}

				$final[ $key ] = $val;
			}
		}

		return $final;
	}

	/**
	 * Function checks if length of string is 60 and also if first part of string contains the
	 *    correct encryption algorithm and cost typical of a Laravel hash. I am not entirely  happy with this as it leaves
	 *    a bit of a hole to allow someone to set their own hash. Not sure why they would want to ...
	 * @param $val
	 * @return bool
	 */
	private function isHash($val)
	{
		return (strlen($val) == 60 && explode("$", $val)[1] == '2y' && explode("$", $val)[2] == '10');
	}
}