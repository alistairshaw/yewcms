<?php namespace AlistairShaw\YewCMS\App\Base\ValueObjects\DateTime;

use AlistairShaw\YewCMS\App\Base\ValueObjects\Util\Util;
use AlistairShaw\YewCMS\App\Base\ValueObjects\ValueObject;

class DateTime implements ValueObject {

	/**
	 * @var object Date
	 */
	protected $date;

	/**
	 * @var object Time
	 */
	protected $time;

	/**
	 * Returns a new DateTime object from native values
	 *    pass in parameters in this order: Year, Month, Day, Hour, Minute, Second
	 * @return DateTime
	 */
	public static function fromNative()
	{
		$args = func_get_args();
		$date = Date::fromNative($args[0], $args[1], $args[2]);
		$time = Time::fromNative($args[3], $args[4], $args[5]);

		return new static($date, $time);
	}

	/**
	 * @param $dateString
	 * @return DateTime
	 */
	public static function fromString($dateString)
	{
		$timestamp = strtotime($dateString);
		return DateTime::fromNative((int)date("Y", $timestamp), date("m", $timestamp), (int)date("d", $timestamp), (int)date("H", $timestamp), (int)date("i", $timestamp), (int)date("s", $timestamp));
	}

	/**
	 * Returns current DateTime
	 *
	 * @return DateTime
	 */
	public static function now()
	{
		$dateTime = new static(Date::now(), Time::now());

		return $dateTime;
	}

	/**
	 * Returns a new DateTime object
	 *
	 * @param Date $date
	 * @param Time $time
	 */
	public function __construct(Date $date, Time $time = null)
	{
		$this->date = $date;
		if (null === $time)
		{
			$time = Time::zero();
		}
		$this->time = $time;
	}

	/**
	 * Compare two ValueObjectInterface and tells whether they can be considered equal
	 *
	 * @param  ValueObject|DateTime $date_time
	 * @return bool
	 */
	public function sameValueAs(ValueObject $date_time)
	{
		if (false === Util::classEquals($this, $date_time))
		{
			return false;
		}

		return $this->getDate()->sameValueAs($date_time->getDate()) && $this->getTime()->sameValueAs($date_time->getTime());
	}

	/**
	 * Returns date from current DateTime
	 *
	 * @return Date
	 */
	public function getDate()
	{
		return clone $this->date;
	}

	/**
	 * Returns time from current DateTime
	 *
	 * @return Time
	 */
	public function getTime()
	{
		return clone $this->time;
	}

	/**
	 * Returns DateTime as string in format "Y-n-j G:i:s"
	 *
	 * @return string
	 */
	public function __toString()
	{
		return \sprintf('%s %s', $this->getDate(), $this->getTime());
	}
}