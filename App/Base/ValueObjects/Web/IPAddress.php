<?php namespace AlistairShaw\YewCMS\App\Base\ValueObjects\Web;

use AlistairShaw\YewCMS\App\Base\Exceptions\InvalidNativeArgumentException;

class IPAddress extends Domain {

    /**
     * Returns a new IPAddress
     *
     * @param string $value
     * @throws InvalidNativeArgumentException
     */
    public function __construct($value)
    {
        parent::__construct($value);
        $filteredValue = filter_var($value, FILTER_VALIDATE_IP);
        if ($filteredValue === false)
        {
            throw new InvalidNativeArgumentException($value, array('string (valid ip address)'));
        }
        $this->value = $filteredValue;
    }

    /**
     * Returns the version (IPv4 or IPv6) of the ip address
     *
     * @return IPAddressVersion
     */
    public function getVersion()
    {
        $isIPv4 = filter_var($this->toNative(), FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        if (false !== $isIPv4)
        {
            return IPAddressVersion::fromNative('IPv4');
        }

        return IPAddressVersion::fromNative('IPv6');
    }
}