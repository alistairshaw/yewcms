<?php namespace AlistairShaw\YewCMS\App\Base\ValueObjects\Web;

use AlistairShaw\YewCMS\App\Base\Exceptions\InvalidNativeArgumentException;

class Hostname extends Domain {

    /**
     * Returns a Hostname
     *
     * @param string $value
     */
    public function __construct($value)
    {
        parent::__construct($value);
        if (0 === \preg_match('/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$/', $value))
        {
            throw new InvalidNativeArgumentException($value, array('string (valid hostname)'));
        }
        $this->value = $value;
    }
}