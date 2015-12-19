<?php namespace AlistairShaw\YewCMS\App\Base\Exceptions;

class InvalidSearchParameterException extends \Exception
{
    public function __construct($value, array $allowed_types)
    {
        $message = sprintf('Search Parameter "%s" is invalid. Allowed types for argument are "%s".', $value, implode(', ', $allowed_types));
        parent::__construct($message);
    }
}