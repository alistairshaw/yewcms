<?php namespace AlistairShaw\YewCMS\App\Base\ValueObjects\DateTime;

use AlistairShaw\YewCMS\App\Base\ValueObjects\Enum\Enum;

class Month extends Enum {

	/**
	 * Months 01-12
	 * @var array
	 */
	protected static $staticAllowed = [
		'01','02','03','04','05','06','07','08','09','10','11','12'
	];

	/**
	 * Get current Month
	 *
	 * @return Month
	 */
	public static function now()
	{
		$now = new \DateTime('now');
		return static::fromNativeDateTime($now);
	}

	/**
	 * Returns Month from a native PHP \DateTime
	 *
	 * @param  \DateTime $date
	 * @return Month
	 */
	public static function fromNativeDateTime(\DateTime $date)
	{
		$month = \strtoupper($date->format('m'));
		return new static($month);
	}

	/**
	 * Returns integer of month
	 */
	public function getNumericValue()
	{
		return (int)$this->toNative();
	}

}