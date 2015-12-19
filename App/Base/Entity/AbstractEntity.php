<?php namespace AlistairShaw\YewCMS\App\Base\Entity;

use AlistairShaw\YewCMS\App\Base\Exceptions\InvalidEntityPropertyException;
use AlistairShaw\YewCMS\App\Base\ValueObjects\Collection;
use AlistairShaw\YewCMS\App\Base\ValueObjects\DataSet;
use AlistairShaw\YewCMS\App\Base\ValueObjects\DateTime\DateTime;
use AlistairShaw\YewCMS\App\Base\ValueObjects\Image\Image;
use ReflectionClass;
use ReflectionProperty;

abstract class AbstractEntity implements Entity {

	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var DateTime
	 */
	protected $createdAt;

	/**
	 * @var DateTime
	 */
	protected $updatedAt;

	/**
	 * @var DateTime
	 */
	protected $deletedAt;

	/**
	 * @var array
	 */
	protected $outputtable = [];

	/**
	 * Overload for shortcut writing
	 * @param $name
	 * @return mixed
	 * @throws InvalidEntityPropertyException
	 */
	public function __get($name)
	{
		if (property_exists($this, $name) && method_exists($this, $name))
		{
			return $this->{$name}();
		}

		throw new InvalidEntityPropertyException($name, get_class($this));
	}

	/**
	 * If a setter exists, then it will call it. If the setter does not exist and the property is public
	 *    then it will just be set.
	 * @param string $name
	 * @param string $value
	 * @return mixed
	 */
	public function __set($name, $value)
	{
		$methodName = 'set' . ucwords($name);
		if (method_exists($this, $methodName))
		{
			$this->{$methodName}($value);

			return $this;
		}

		if (property_exists($this, $name))
		{
			$this->{$name} = $value;

			return $this;
		}

		throw new InvalidEntityPropertyException($name, get_class($this));
	}

	/**
	 * @param $name
	 * @return bool
	 */
	public function __isset($name)
	{
		if (property_exists($this, $name) && method_exists($this, $name))
		{
			return true;
		}

		return false;
	}

	public function __unset($name)
	{
		$methodName = 'unset' . ucwords($name);
		if (property_exists($this, $name) && method_exists($this, $methodName))
		{
			$this->{$methodName}();

			return $this;
		}

		if (property_exists($this, $name))
		{
			$this->{$name} = null;

			return $this;
		}

		throw new InvalidEntityPropertyException($name, get_class($this));
	}

	/**
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return int
	 */
	public function id()
	{
		return $this->id;
	}

	/**
	 * @param DateTime $createdAt
	 */
	public function setCreatedAt(DateTime $createdAt)
	{
		$this->createdAt = $createdAt;
	}

	/**
	 * @return string
	 */
	public function createdAt()
	{
		return $this->createdAt;
	}

	/**
	 * @param DateTime $updatedAt
	 */
	public function setUpdatedAt(DateTime $updatedAt)
	{
		$this->updatedAt = $updatedAt;
	}

	/**
	 * @return DateTime
	 */
	public function updatedAt()
	{
		return $this->updatedAt;
	}

	/**
	 * @param DateTime $deletedAt
	 * @return void
	 */
	public function setDeletedAt(DateTime $deletedAt)
	{
		$this->deletedAt = $deletedAt;
	}

	/**
	 * @return string
	 */
	public function deletedAt()
	{
		return $this->deletedAt;
	}

	/**
	 * Returns array of all public and protected values from an entity. Will NOT return private values
	 */
	public function toArray()
	{
		$final   = array();
		$reflect = new ReflectionClass($this);
		$props   = $reflect->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED);
		foreach ($props as $prop)
		{
			$propName = $prop->getName();
			if ($propName !== 'outputtable' && ! $propName instanceof Collection)
			{
				$final[ $propName ] = $this->{$propName};
				if (is_object($this->{$propName})) $final[ $propName ] = $this->{$propName}->__toString();
			}
		}

		return $final;
	}

	/**
	 * Returns array of all variables that are set in outputtable
	 * @param array $extraFields Array of any additional fields you want to get from the entity
	 * @return array
	 */
	public function toOutput($extraFields = [])
	{
		$final   = array();
		$reflect = new ReflectionClass($this);
		$props   = $reflect->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED);
		foreach ($props as $prop)
		{
			$propName = $prop->getName();
			if (in_array($propName, $this->outputtable) || (in_array($propName, $extraFields)))
			{
				$final[ $propName ] = $this->{$propName};

				if ($this->{$propName} instanceof Collection)
				{
					$final[ $propName ] = [];
					foreach ($this->{$propName} as $item)
					{
						$final[ $propName ][] = $item->__toString();
					}
					continue;
				}

				if ($this->{$propName} instanceof DataSet)
				{
					$final[ $propName ] = $this->{$propName}->toArray();
					continue;
				}

				if ($this->{$propName} instanceof Image)
				{
					$final[ $propName ] = Image::getPicArray($this->{$propName});
					continue;
				}

				if (is_object($this->{$propName})) $final[ $propName ] = $this->{$propName}->__toString();
			}
		}

		return $final;
	}

	/**
	 * Returns list of outputtable fields for this entity
	 */
	public function getOutputtable()
	{
		return $this->outputtable;
	}
}