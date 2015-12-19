<?php namespace AlistairShaw\YewCMS\App\Base\ValueObjects\String;

use AlistairShaw\YewCMS\App\Base\ValueObjects\Util\Util;
use AlistairShaw\YewCMS\App\Base\ValueObjects\ValueObject;

class String implements ValueObject {

    /**
     * @var string
     */
    protected $value;

    /**
     * Returns a object taking PHP native value(s) as argument(s).
     *
     * @return ValueObject
     */
    public static function fromNative()
    {
        $value = func_get_args()[0];

        return new static($value);
    }

    /**
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = (string) $value;
    }

    /**
     * Compare two ValueObjectInterface and tells whether they can be considered equal
     *
     * @param  ValueObject $string
     * @return bool
     */
    public function sameValueAs(ValueObject $string)
    {
        if (false === Util::classEquals($this, $string))
        {
            return false;
        }

        return $this->toNative() === $string->toNative();
    }

    /**
     * @return string
     */
    public function toNative()
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return (strlen($this->value) == 0);
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }
}