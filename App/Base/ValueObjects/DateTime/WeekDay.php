<?php namespace AlistairShaw\YewCMS\App\Base\ValueObjects\DateTime;

use AlistairShaw\YewCMS\App\Base\ValueObjects\Enum\Enum;
use AlistairShaw\YewCMS\App\Base\ValueObjects\ValueObject;

class WeekDay extends Enum implements ValueObject {

	/**
	 * @var array
	 */
	protected static $staticAllowed = [1, 2, 3, 4, 5, 6, 7];

	/**
	 * @var array
	 */
	protected static $staticFriendlyNames = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

}