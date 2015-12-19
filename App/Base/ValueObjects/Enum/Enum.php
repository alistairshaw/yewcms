<?php namespace AlistairShaw\YewCMS\App\Base\ValueObjects\Enum;

use AlistairShaw\YewCMS\App\Base\Exceptions\InvalidNativeArgumentException;
use AlistairShaw\YewCMS\App\Base\ValueObjects\Util\Util;
use AlistairShaw\YewCMS\App\Base\ValueObjects\ValueObject;

abstract class Enum implements ValueObject {

    /**
     * @var array
     */
    protected static $staticAllowed = [];

    /**
     * @var array
     */
    protected static $staticFriendlyNames = [];

    /**
     * @var array
     */
    protected $allowed = [];

    /**
     * @var string
     */
    protected $value;

    /**
     * @return array
     */
    public static function listValues()
    {
        return static::$staticAllowed;
    }

    /**
     * @return array
     */
    public static function getKeyPairValues()
    {
        $allowed   = static::$staticAllowed;
        $niceNames = static::$staticFriendlyNames;

        $final = [];
        for ($i = 0; $i < count($allowed); $i ++)
        {
            $label   = isset($niceNames[ $i ]) ? $niceNames[ $i ] : $allowed[ $i ];
            $final[] = [$allowed[ $i ] => $label];
        }

        return $final;
    }

    /**
     * Returns a object taking PHP native value(s) as argument(s).
     * @return Mixed
     */
    public static function fromNative()
    {
        $value = func_get_arg(0);

        return new static($value);
    }

    /**
     * @param $value
     * @throws InvalidNativeArgumentException
     */
    public function __construct($value)
    {
        $this->value = $this->checkValid($value);
    }

    /**
     * @return string
     */
    public function getFriendly()
    {
        for ($i = 0; $i < count(static::$staticAllowed); $i ++)
        {
            if (static::$staticAllowed[ $i ] == $this->value)
            {
                if (isset(static::$staticFriendlyNames[ $i ])) return static::$staticFriendlyNames[ $i ];
            }
        }

        return $this->value;
    }

    /**
     * @param $value
     * @return mixed
     */
    protected function checkValid($value)
    {
        $this->allowed = [];
        foreach (static::$staticAllowed as $allowedValue)
        {
            $this->allowed[] = $allowedValue;
        }

        if ( ! in_array($value, $this->allowed))
        {
            throw new InvalidNativeArgumentException($value, $this->allowed);
        }

        return $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value;
    }

    /**
     * Returns the PHP native value of the enum
     *
     * @return mixed
     */
    public function toNative()
    {
        return $this->value;
    }

    /**
     * Compare two ValueObjectInterface and tells whether they can be considered equal
     *
     * @param ValueObject|Enum $enum
     * @return bool
     */
    public function sameValueAs(ValueObject $enum)
    {
        if (false === Util::classEquals($this, $enum))
        {
            return false;
        }

        return $this->toNative() === $enum->toNative();
    }

    /**
     * @return int|null
     */
    protected function getKey()
    {
        foreach (static::$staticAllowed as $key => $allowedValue)
        {
            if ($this->value == $allowedValue) return $key;
        }

        return null;
    }
}