<?php namespace AlistairShaw\YewCMS\App\Base\ValueObjects\String;

use AlistairShaw\YewCMS\App\Base\Exceptions\InvalidNativeArgumentException;
use Hash;

class Password extends String {

    /**
     * @param $password
     * @return Password
     */
    public static function fromPlainText($password)
    {
        // password must be more than 4 characters long
        $password = (string)$password;
        if (strlen($password) < 4) throw new InvalidNativeArgumentException($password, ['Min 4 Characters']);

        return new static(Hash::make($password));
    }

    /**
     * @param $hash
     */
    public function __construct($hash)
    {
        parent::__construct($hash);
        $this->value = $hash;
    }

}