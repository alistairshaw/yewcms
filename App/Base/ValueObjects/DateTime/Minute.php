<?php namespace AlistairShaw\YewCMS\App\Base\ValueObjects\DateTime;

use AlistairShaw\YewCMS\App\Base\Exceptions\InvalidNativeArgumentException;
use AlistairShaw\YewCMS\App\Base\ValueObjects\Number\Natural;

class Minute extends Natural {

	/**
	 * Returns a new Minute from native int value
	 * @return Minute
	 */
	public static function fromNative()
	{
		$value = func_get_arg(0);

		return new static($value);
	}

	/**
	 * Returns a new Minute object
	 *
	 * @param int $value
	 * @throws InvalidNativeArgumentException
	 */
	public function __construct($value)
	{
		$options = array(
			'options' => array('min_range' => 0, 'max_range' => 59)
		);
		$value   = filter_var($value, FILTER_VALIDATE_INT, $options);
		if (false === $value)
		{
			throw new InvalidNativeArgumentException($value, array('int (>=0, <=59)'));
		}
		parent::__construct($value);
	}

	/**
	 * Returns the current minute.
	 *
	 * @return Minute
	 */
	public static function now()
	{
		$now    = new \DateTime('now');
		$minute = \intval($now->format('i'));

		return new static($minute);
	}

}