<?php namespace AlistairShaw\YewCMS\App\Base\ValueObjects\DateTime;

use AlistairShaw\YewCMS\App\Base\Exceptions\InvalidNativeArgumentException;
use AlistairShaw\YewCMS\App\Base\ValueObjects\Number\Natural;

class Hour extends Natural {

	/**
	 * Returns a new Hour from native int value
	 * @return Hour
	 * @internal param int $value
	 */
	public static function fromNative()
	{
		$value = func_get_arg(0);
		return new static($value);
	}

	/**
	 * Returns a new Hour object
	 *
	 * @param int $value
	 * @throws InvalidNativeArgumentException
	 */
	public function __construct($value)
	{
		$options = array(
			'options' => array('min_range' => 0, 'max_range' => 23)
		);
		$value = filter_var($value, FILTER_VALIDATE_INT, $options);
		if (false === $value) {
			throw new InvalidNativeArgumentException($value, array('int (>=0, <=23)'));
		}
		parent::__construct($value);
	}
	/**
	 * Returns the current hour.
	 *
	 * @return Hour
	 */
	public static function now()
	{
		$now  = new \DateTime('now');
		$hour = \intval($now->format('G'));
		return new static($hour);
	}

}