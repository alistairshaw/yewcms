<?php namespace AlistairShaw\YewCMS\App\Base\ValueObjects\Web;

use AlistairShaw\YewCMS\App\Base\ValueObjects\Enum\Enum;

class IPAddressVersion extends Enum
{
    protected static $staticAllowed = ['IPv4', 'IPv6'];
}