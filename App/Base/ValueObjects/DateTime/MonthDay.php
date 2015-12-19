<?php namespace AlistairShaw\YewCMS\App\Base\ValueObjects\DateTime;

use AlistairShaw\YewCMS\App\Base\Exceptions\InvalidNativeArgumentException;
use AlistairShaw\YewCMS\App\Base\ValueObjects\Number\Natural;

class MonthDay extends Natural {

	/**
	 * Returns a new MonthDay
	 *
	 * @param int $value
	 * @throws InvalidNativeArgumentException
	 */
	public function __construct($value)
	{
		$options = array(
			'options' => array('min_range' => 1, 'max_range' => 31)
		);
		$value = filter_var($value, FILTER_VALIDATE_INT, $options);
		if (false === $value) {
			throw new InvalidNativeArgumentException($value, array('int (>=0, <=31)'));
		}
		parent::__construct($value);
	}

	/**
	 * Returns the current month day.
	 *
	 * @return MonthDay
	 */
	public static function now()
	{
		$now      = new \DateTime('now');
		$monthDay = \intval($now->format('j'));
		return new static($monthDay);
	}

}