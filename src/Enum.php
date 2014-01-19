<?php
/**
 * Enum class.
 *
 * @copyright 2014 Derrick Nelson
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    Derrick Nelson <drrcknlsn@gmail.com>
 */
namespace drrcknlsn\Enum;

use BadMethodCallException;
use ReflectionClass;

/**
 * Base class for enumerations.
 */
class Enum
{
    /**
     * The value cache for all enumerations.
     *
     * @var mixed[]
     */
    private static $values;

    /**
     * The instance cache for all enumerations.
     *
     * @var mixed[]
     */
    private static $instances;

    /**
     * The value.
     *
     * @var mixed
     */
    private $value;

    /**
     * Creates a new constant instance.
     *
     * @param mixed $value The value.
     */
    final private function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Retrieves the string representation of the constant's value.
     *
     * @return string
     */
    final public function __toString()
    {
        return (string)$this->getValue();
    }

    /**
     * Retrieves the constant's value.
     *
     * @return mixed The constant's value.
     */
    final public function getValue()
    {
        return $this->value;
    }

    /**
     * Factory method to turns static calls into constant instances.
     *
     * @param string  $name The name.
     * @param mixed[] $args The arguments.
     *
     * @return self
     */
    final public static function __callStatic($name, array $args)
    {
        $class = get_called_class();
        self::createValueCache($class);

        if (!isset(self::$values[$class][$name])) {
            throw new BadMethodCallException();
        }

        if (!isset(self::$instances[$class][$name])) {
            self::$instances[$class][$name] = new static(self::$values[$class][$name]);
        }

        return self::$instances[$class][$name];
    }

    /**
     * Retrieves the enumeration as an array of constant/value pairs.
     *
     * @return mixed[]
     */
    final public static function getValues()
    {
        $class = get_called_class();
        self::createValueCache($class);

        return self::$values[$class];
    }

    /**
     * Creates the value cache for the provided enumeration class.
     *
     * @param string $class The class.
     */
    private static function createValueCache($class)
    {
        if (isset(self::$values[$class])) {
            return;
        }

        self::$values[$class] = [];
        $ref = new ReflectionClass($class);
        $defaultValue = 0;

        foreach ($ref->getStaticProperties() as $key => $value) {
            if (!isset($value)) {
                $value = $defaultValue;
            }

            self::$values[$class][$key] = $value;

            $defaultValue = $value + 1;
        }
    }
}
