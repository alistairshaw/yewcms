<?php namespace AlistairShaw\YewCMS\App\Base\Exceptions;

class InvalidDateException extends \Exception
{
	/**
	 * @param string     $year
	 * @param int        $month
	 * @param int		 $day
	 */
	public function __construct($year, $month, $day)
	{
		$date    = \sprintf('%d-%d-%d', $year, $month, $day);
		$message = \sprintf('The date "%s" is invalid.', $date);
		parent::__construct($message);
	}
}