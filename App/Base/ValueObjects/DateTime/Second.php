<?php namespace AlistairShaw\YewCMS\App\Base\ValueObjects\DateTime;

use AlistairShaw\YewCMS\App\Base\Exceptions\InvalidNativeArgumentException;
use AlistairShaw\YewCMS\App\Base\ValueObjects\Number\Natural;

class Second extends Natural {

	/**
	 * Returns a new Second object
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
	 * Returns the current second.
	 *
	 * @return Second
	 */
	public static function now()
	{
		$now    = new \DateTime('now');
		$second = \intval($now->format('s'));

		return new static($second);
	}
}