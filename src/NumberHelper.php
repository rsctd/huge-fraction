<?php


namespace Rsctd\HugeFraction;

/**
 * Class NumberHelper
 *
 * @package Rsctd\HugeFraction
 * @author  Rsctd Team <super.rsctd@gmail.com>
 */
class NumberHelper
{
    /**
     * Zero value
     */
    const ZERO = '0';

    /**
     * Check if a number is an integer
     *
     * @param  string  $number
     *
     * @return bool
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public static function validate(string $number): bool
    {
        return preg_match('/^[-]?\d+$/', $number) === 1;
    }

    /**
     * Check if a number is zero
     *
     * @param  string  $number
     *
     * @return bool
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public static function isZero(string $number): bool
    {
        return '0' === $number || '-0' === $number;
    }

    /**
     * Check if a number is an unsigned number
     *
     * @param  string  $number
     *
     * @return bool
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public static function isUnsigned(string $number): bool
    {
        return FALSE !== strpos($number, '-') && !self::isZero($number);
    }

    /**
     * Check if a number is a signed number
     *
     * @param  string  $number
     *
     * @return bool
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public static function isSigned(string $number): bool
    {
        return FALSE === strpos($number, '-') && !self::isZero($number);
    }

    /**
     * Get abs of a number
     *
     * @param  string  $number
     *
     * @return string
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public static function abs(string $number): string
    {
        if (self::isZero($number)) {
            return self::ZERO;
        }
        if (self::isUnsigned($number)) {
            return substr($number, 1);
        }
        return $number;
    }

    /**
     * Compare two numbers
     *
     *  * -1: number1 < number2
     *  *  0: number1 = number2
     *  *  1: number1 > number2
     *
     * @param  string  $number1
     * @param  string  $number2
     *
     * @return int
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public static function compare(string $number1, string $number2): int
    {
        if (self::isUnsigned($number1) && self::isSigned($number2)) {
            return -1;
        }
        if (self::isSigned($number1) && self::isUnsigned($number2)) {
            return 1;
        }
        $number1 = self::abs($number1);
        $number2 = self::abs($number2);
        $length1 = strlen($number1);
        $length2 = strlen($number2);
        if ($length1 < $length2) {
            return -1;
        }
        if ($length1 > $length2) {
            return 1;
        }
        for ($i = 0; $i < $length1; $i++) {
            $n1 = (int)$number1[$i];
            $n2 = (int)$number2[$i];
            if ($n1 < $n2) {
                return -1;
            }
            if ($n1 > $n2) {
                return 1;
            }
        }
        return 0;
    }

    /**
     * Get int part of float number
     *
     * @param  string  $number
     *
     * @return string
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public static function floor(string $number): string
    {
        $matches = [];
        preg_match('/^([-]?\d+)(\.)?(\d)*$/', $number, $matches);
        if (count($matches) > 1) {
            return $matches[1];
        }
        throw new \InvalidArgumentException();
    }

    /**
     * Get min number
     *
     * @param  string  $number1
     * @param  string  $number2
     *
     * @return string
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public static function min(string $number1, string $number2): string
    {
        if (self::compare($number1, $number2) <= 0) {
            return $number1;
        }
        return $number2;
    }

    /**
     * Get max number
     *
     * @param  string  $number1
     * @param  string  $number2
     *
     * @return string
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public static function max(string $number1, string $number2): string
    {
        if (self::compare($number1, $number2) >= 0) {
            return $number1;
        }
        return $number2;
    }

    /**
     * Get greatest common divisor
     *
     * @param  string  $number1
     * @param  string  $number2
     *
     * @return string
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public static function getGreatestCommonDivisor(string $number1, string $number2): string
    {
        if (self::isZero($number1) || self::isZero($number2)) {
            return '1';
        }
        $min = self::min($number1, $number2);
        $max = self::max($number1, $number2);

        $mod = bcmod($max, $min);
        while (self::isSigned($mod)) {
            $max = $min;
            $min = $mod;
            $mod = bcmod($max, $min);
        }
        return $min;
    }
}
