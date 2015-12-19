<?php namespace AlistairShaw\YewCMS\App\Base\ValueObjects\Number;

use AlistairShaw\YewCMS\App\Base\Exceptions\InvalidNativeArgumentException;

class Integer extends Real {

	/**
	 * Returns a Integer object given a PHP native int as parameter.
	 *
	 * @param int $value
	 * @throws InvalidNativeArgumentException
	 */
	public function __construct($value)
	{
		$value = filter_var($value, FILTER_VALIDATE_INT);
		if (false === $value) {
			throw new InvalidNativeArgumentException($value, array('int'));
		}
		parent::__construct($value);
	}

	/**
	 * Returns the value of the integer number
	 *
	 * @return int
	 */
	public function toNative()
	{
		$value = parent::toNative();
		return \intval($value);
	}

}