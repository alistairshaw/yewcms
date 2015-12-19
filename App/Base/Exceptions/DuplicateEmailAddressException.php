<?php namespace AlistairShaw\YewCMS\App\Base\Exceptions;

class DuplicateEmailAddressException extends \Exception
{
    public function __construct($value)
    {
        $message = sprintf('Email address "%s" already exists. Please sign in.', $value);
        parent::__construct($message);
    }
}