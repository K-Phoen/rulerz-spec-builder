<?php

namespace RulerZ\Spec;

/**
 * Factory for Specification instances.
 *
 * Use this class to build specifications:
 *
 * ```php
 * $spec = Expr::andX(
 *     Expr::equals('gender', 'F'),
 *     Expr::moreThan('points', 3000)
 * );
 * ```
 *
 * This is equivalent to `gender = "F" and points > 3000`
 *
 * Here is a more complex example:
 *
 * ```php
 * $spec = Expr::orX(
 *     Expr::andX(
 *         Expr::equals('gender', 'F'),
 *         Expr::moreThan('points', 3000)
 *     ),
 *     Expr::andX(
 *         Expr::equals('gender', 'M'),
 *         Expr::moreThan('points', 6000)
 *     )
 * );
 * ```
 *
 * Which is equivalent to: `(gender = "F" and points > 3000) or (gender = "M" and points > 6000)`
 */
class Expr
{
    /**
     * Create a conjunction of specifications.
     *
     * @param Specification ...$specifications
     *
     * @return \RulerZ\Spec\Specification
     */
    public static function andX(Specification ...$specifications)
    {
        return new AndX($specifications);
    }

    /**
     * Create a disjunction of specifications.
     *
     * @param Specification ...$specifications
     *
     * @return \RulerZ\Spec\Specification
     */
    public static function orX(Specification ...$specifications)
    {
        return new OrX($specifications);
    }

    /**
     * Negate a specification.
     *
     * @param Specification $specification
     *
     * @return \RulerZ\Spec\Specification
     */
    public static function not(Specification $specification)
    {
        return new Not($specification);
    }

    /**
     * Check that a value equals another value.
     *
     * @param $key
     * @param $value
     *
     * @return Specification
     */
    public static function equals($key, $value)
    {
        return self::createSpec($key, $value, '=');
    }

    /**
     * Check that a value is not equal to another value.
     *
     * @param $key
     * @param $value
     *
     * @return Specification
     */
    public static function notEquals($key, $value)
    {
        return self::createSpec($key, $value, '!=');
    }

    /**
     * Check that a value strictly equals another value.
     *
     * @param $key
     * @param $value
     *
     * @return Specification
     */
    public static function is($key, $value)
    {
        return self::createSpec($key, $value, 'is');
    }

    /**
     * Check that a value is NOT strictly equal to another value.
     *
     * @param $key
     * @param $value
     *
     * @return Specification
     */
    public static function isNot($key, $value)
    {
        return self::not(self::is($key, $value));
    }

    /**
     * Check that a value is inferior to another value.
     *
     * @param $key
     * @param $value
     *
     * @return Specification
     */
    public static function lessThan($key, $value)
    {
        return self::createSpec($key, $value, '<');
    }

    /**
     * Check that a value is inferior or equal to another value.
     *
     * @param $key
     * @param $value
     *
     * @return Specification
     */
    public static function lessThanEqual($key, $value)
    {
        return self::createSpec($key, $value, '<=');
    }

    /**
     * Check that a value is superior to another value.
     *
     * @param $key
     * @param $value
     *
     * @return Specification
     */
    public static function moreThan($key, $value)
    {
        return self::createSpec($key, $value, '>');
    }

    /**
     * Check that a value is superior or equal to another value.
     *
     * @param $key
     * @param $value
     *
     * @return Specification
     */
    public static function moreThanEqual($key, $value)
    {
        return self::createSpec($key, $value, '>=');
    }

    /**
     * Check that a value is in a given list.
     *
     * @param $key
     * @param $value
     *
     * @return Specification
     */
    public static function in($key, $value)
    {
        return self::createSpec($key, $value, 'in');
    }

    /**
     * Calls an operator/a function.
     *
     * Example:
     * ```php
     * $spec = Expr::func('like', 'attribute', 'terms');
     * ```
     *
     * @param string $function Function name.
     * @param mixed ...$arguments
     *
     * @return Specification
     */
    public static function func($function, ...$arguments)
    {
        $argumentsList = implode(', ', array_map('self::formatValue', $arguments));
        $rule = sprintf('%s(%s)', $function, $argumentsList);

        return new GenericSpec($rule);
    }

    /**
     * Check that a value is NOT in a given list.
     *
     * @param $key
     * @param $value
     *
     * @return Specification
     */
    public static function notIn($key, $value)
    {
        return self::not(self::in($key, $value));
    }

    /**
     * @param $key
     * @param $value
     * @param $operator
     *
     * @return Specification
     */
    private static function createSpec($key, $value, $operator)
    {
        return new GenericSpec(sprintf('%s %s %s', $key, $operator, self::formatValue($value)));
    }

    /**
     * @param $value
     *
     * @return string
     */
    private static function formatValue($value)
    {
        if (is_array($value)) {
            $formattedValues = array_map('self::formatValue', $value);

            return sprintf('[%s]', implode(', ', $formattedValues));
        }

        if (empty($value)) {
            return '""';
        }

        if (ctype_digit($value)) {
            return $value;
        }

        if ($value[0] == ':') {
            return $value;
        }

        return var_export($value, true);
    }
}
