<?php namespace AlistairShaw\YewCMS\App\Base\ValueObjects\Number;

interface Number {

	/**
	 * Returns a PHP native implementation of the Number value
	 *
	 * @return mixed
	 */
	public function toNative();

}