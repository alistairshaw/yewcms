<?php namespace AlistairShaw\YewCMS\App\Base\Exceptions;

class InvalidPathException extends \Exception {

    public function __construct($path = '')
    {
        $message = 'Invalid Path';
        if ($path !== '') $message .= ': ' . $path;
        parent::__construct($message);
    }
}