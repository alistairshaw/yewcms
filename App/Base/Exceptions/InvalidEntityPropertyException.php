<?php namespace AlistairShaw\YewCMS\App\Base\Exceptions;

class InvalidEntityPropertyException extends \InvalidArgumentException
{
    public function __construct($value, $className)
    {
        $this->message = sprintf('Property "%s" does not exist on "%s"', $value, $className);
    }
}