<?php namespace AlistairShaw\YewCMS\App\Base\Exceptions;

class InvalidNativeArgumentException extends \InvalidArgumentException
{
    public function __construct($value, array $allowed_types)
    {
        $this->message = sprintf('Argument "%s" is invalid. Allowed types for argument are "%s".', $value, implode(', ', $allowed_types));
    }
}