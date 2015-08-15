<?php

namespace RulerZ\Spec;

class Expr
{
    public static function andX(Specification ...$specifications)
    {
        return new AndX($specifications);
    }

    public static function orX(Specification ...$specifications)
    {
        return new OrX($specifications);
    }

    public static function not(Specification $specification)
    {
        return new Not($specification);
    }

    public static function equals($key, $value)
    {
        return self::buildSpec($key, $value, '=');
    }

    public static function notEquals($key, $value)
    {
        return self::buildSpec($key, $value, '!=');
    }

    public static function is($key, $value)
    {
        return self::buildSpec($key, $value, 'is');
    }

    public static function isNot($key, $value)
    {
        return self::not(self::is($key, $value));
    }

    public static function lessThan($key, $value)
    {
        return self::buildSpec($key, $value, '<');
    }

    public static function lessThanEqual($key, $value)
    {
        return self::buildSpec($key, $value, '<=');
    }

    public static function moreThan($key, $value)
    {
        return self::buildSpec($key, $value, '>');
    }

    public static function moreThanEqual($key, $value)
    {
        return self::buildSpec($key, $value, '>=');
    }

    public static function in($key, $value)
    {
        return self::buildSpec($key, $value, 'in');
    }

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
    private static function buildSpec($key, $value, $operator)
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