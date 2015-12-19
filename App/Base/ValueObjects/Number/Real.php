<?php namespace AlistairShaw\YewCMS\App\Base\ValueObjects\Number;

use AlistairShaw\YewCMS\App\Base\Exceptions\InvalidNativeArgumentException;
use AlistairShaw\YewCMS\App\Base\ValueObjects\Util\Util;
use AlistairShaw\YewCMS\App\Base\ValueObjects\ValueObject;

class Real implements ValueObject, Number {

	protected $value;

	/**
	 * Returns a PHP native implementation of the Number value
	 *
	 * @return mixed
	 */
	public function toNative()
	{
		return $this->value;
	}

	/**
	 * Returns a object taking PHP native value(s) as argument(s).
	 *
	 * @return ValueObject
	 */
	public static function fromNative()
	{
		$value = func_get_arg(0);

		return new static($value);
	}

	/**
	 * @param $value
	 * @throws InvalidNativeArgumentException
	 */
	public function __construct($value)
	{
		$value = \filter_var($value, FILTER_VALIDATE_FLOAT);
		if (false === $value)
		{
			throw new InvalidNativeArgumentException($value, array('float'));
		}
		$this->value = $value;
	}

	/**
	 * Compare two ValueObjectInterface and tells whether they can be considered equal
	 *
	 * @param Real|ValueObject $real
	 * @return bool
	 */
	public function sameValueAs(ValueObject $real)
	{
		if (false === Util::classEquals($this, $real))
		{
			return false;
		}

		return $this->toNative() === $real->toNative();
	}

	/**
	 * Returns a string representation of the object
	 *
	 * @return string
	 */
	public function __toString()
	{
		return \strval($this->toNative());
	}
}