<?php


namespace Rsctd\HugeFraction;

/**
 * Class DenominatorHelper
 *
 * @package Rsctd\HugeFraction
 * @author  Rsctd Team <super.rsctd@gmail.com>
 */
class DenominatorHelper
{
    /**
     * Check if a number is a valid denominator (is not zero)
     *
     * @param  string  $number
     *
     * @return bool
     * @author  Rsctd Team <super.rsctd@gmail.com>
     */
    public static function validate(string $number): bool
    {
        return NumberHelper::validate($number) && NumberHelper::isZero($number) === FALSE;
    }
}
