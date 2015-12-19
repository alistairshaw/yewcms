<?php namespace AlistairShaw\YewCMS\App\Base\Exceptions;

class InvalidIdException extends \Exception
{
    public function __construct($value)
    {
        $message = sprintf('"%s" is not a valid ID.', $value);
        parent::__construct($message);
    }
}