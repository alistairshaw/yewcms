<?php namespace AlistairShaw\YewCMS\App\Base\ValueObjects\String;

class AuthToken extends String {

    /**
     * @var string
     */
    private $validChars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123467890';

    /**
     * No need to pass anything in
     * @param string $token
     */
    public function __construct($token = '')
    {
        parent::__construct($token);
        $this->value = ($token) ? $this->fromNative($token) : $this->generateToken(30);
    }

    /**
     * @param int $length
     * @return string
     */
    private function generateToken($length = 30)
    {
        $random = '';
        for ($i = 0; $i < $length; $i++)
        {
            $randomNumber = rand(0, strlen($this->validChars) - 1);
            $random .= substr($this->validChars, $randomNumber, 1);
        }

        return $random;
    }

    /**
     * Returns a object taking PHP native value(s) as argument(s).
     *
     * @return AuthToken
     */
    public static function fromNative()
    {
        $value = func_get_args()[0];
        $token = new static();
        $token->setToken($value);
        return $token;
    }

    /**
     * @param $value
     */
    public function setToken($value)
    {
        $this->value = (string) $value;
    }

}