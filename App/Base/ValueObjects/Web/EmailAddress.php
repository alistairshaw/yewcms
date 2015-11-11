<?php namespace AlistairShaw\YewCMS\App\Base\ValueObjects\Web;

use AlistairShaw\YewCMS\App\Base\Exceptions\InvalidNativeArgumentException;
use AlistairShaw\YewCMS\App\Base\ValueObjects\String\String;

class EmailAddress extends String {

    /**
     * Returns an EmailAddress object given a PHP native string as parameter.
     *
     * @param string $value
     * @throws InvalidNativeArgumentException
     */
    public function __construct($value)
    {
        parent::__construct($value);
        $filteredValue = filter_var($value, FILTER_VALIDATE_EMAIL);
        if ($filteredValue === false)
        {
            throw new InvalidNativeArgumentException($value, array('string (valid email address)'));
        }
        $this->value = $filteredValue;
    }

    /**
     * Returns the local part of the email address
     *
     * @return String
     */
    public function getLocalPart()
    {
        $parts     = explode('@', $this->toNative());
        $localPart = new String($parts[0]);

        return $localPart;
    }

    /**
     * Returns the domain part of the email address
     *
     * @return Domain
     */
    public function getDomainPart()
    {
        $parts  = \explode('@', $this->toNative());
        $domain = \trim($parts[1], '[]');

        return Domain::specifyType($domain);
    }

}