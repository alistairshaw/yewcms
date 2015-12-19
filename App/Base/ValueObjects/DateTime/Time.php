<?php namespace AlistairShaw\YewCMS\App\Base\ValueObjects\DateTime;

use AlistairShaw\YewCMS\App\Base\ValueObjects\Util\Util;
use AlistairShaw\YewCMS\App\Base\ValueObjects\ValueObject;

class Time implements ValueObject {

	/**
	 * @var Hour
	 */
	protected $hour;

	/**
	 * @var Minute
	 */
	protected $minute;

	/**
	 * @var Second
	 */
	protected $second;

	/**
	 * Returns a object taking PHP native value(s) as argument(s).
	 *     Parameters: Hour, Minute, Second
	 * @return ValueObject
	 */
	public static function fromNative()
	{
		$args = func_get_args();

		$hour   = new Hour($args[0]);
		$minute = new Minute($args[1]);
		$second = new Second($args[2]);

		return new static($hour, $minute, $second);
	}

	/**
	 * Returns current Time
	 *
	 * @return self
	 */
	public static function now()
	{
		$time = new static(Hour::now(), Minute::now(), Second::now());

		return $time;
	}

	/**
	 * Returns a new Time object
	 *
	 * @param Hour   $hour
	 * @param Minute $minute
	 * @param Second $second
	 */
	public function __construct(Hour $hour, Minute $minute, Second $second)
	{
		$this->hour   = $hour;
		$this->minute = $minute;
		$this->second = $second;
	}

	/**
	 * Return zero time
	 *
	 * @return static
	 */
	public static function zero()
	{
		$time = new static(new Hour(0), new Minute(0), new Second(0));
		return $time;
	}

	/**
	 * Compare two ValueObjectInterface and tells whether they can be considered equal
	 *
	 * @param ValueObject|Time $time
	 * @return bool
	 */
	public function sameValueAs(ValueObject $time)
	{
		if (false === Util::classEquals($this, $time))
		{
			return false;
		}

		return $this->getHour()->sameValueAs($time->getHour()) && $this->getMinute()->sameValueAs($time->getMinute()) && $this->getSecond()->sameValueAs($time->getSecond());
	}

	/**
	 * Get hour
	 *
	 * @return Hour
	 */
	public function getHour()
	{
		return $this->hour;
	}
	/**
	 * Get minute
	 *
	 * @return Minute
	 */
	public function getMinute()
	{
		return $this->minute;
	}
	/**
	 * Get second
	 *
	 * @return Second
	 */
	public function getSecond()
	{
		return $this->second;
	}

	/**
	 * Returns a native PHP \DateTime version of the current Time.
	 * Date is set to current.
	 *
	 * @return \DateTime
	 */
	public function toNativeDateTime()
	{
		$hour   = $this->getHour()->toNative();
		$minute = $this->getMinute()->toNative();
		$second = $this->getSecond()->toNative();
		$time = new \DateTime('now');
		$time->setTime($hour, $minute, $second);
		return $time;
	}

	/**
	 * Returns a string representation of the object
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->toNativeDateTime()->format('H:i:s');
	}
}