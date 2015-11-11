<?php namespace AlistairShaw\YewCMS\App\Base\ValueObjects;

interface ValueObject {

    /**
     * Returns a object taking PHP native value(s) as argument(s).
     *
     * @return ValueObject
     */
    public static function fromNative();

    /**
     * Compare two ValueObjectInterface and tells whether they can be considered equal
     *
     * @param  ValueObject $object
     * @return bool
     */
    public function sameValueAs(ValueObject $object);

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function __toString();

}