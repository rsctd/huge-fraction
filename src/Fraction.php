<?php

/*
 * Rsctd Huge Fraction package
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rsctd\HugeFraction;

/**
 * Fraction Class
 *
 * @author Rsctd Team <super.rsctd@gmail.com>
 */
class Fraction
{
    /**
     * Sign
     *
     * @var bool
     */
    private $signed = TRUE;

    /**
     * Numerator
     *
     * @var string
     */
    private $numerator;

    /**
     * Denominator
     *
     * @var string
     */
    private $denominator;

    /**
     * Construct function
     *
     * @param  string  $numerator
     * @param  string  $denominator
     *
     * @author Rsctd Team <super.rsctd@gmail.com>
     *
     */
    public function __construct(string $numerator, string $denominator = '1')
    {
        if (!NumberHelper::validate($numerator)) {
            throw new \InvalidArgumentException();
        }
        if (!DenominatorHelper::validate($denominator)) {
            throw new \InvalidArgumentException();
        }

        if (NumberHelper::isZero($numerator)) {
            $this->numerator = '0';
            $this->denominator = '1';

            return;
        }

        $this->numerator = ltrim($numerator, NumberHelper::ZERO);
        $this->denominator = ltrim($denominator, NumberHelper::ZERO);
        $this->getSigned();
        $this->simplify();
    }

    /**
     * Get signed of fraction
     *
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    private function getSigned()
    {
        if (NumberHelper::isUnsigned($this->numerator) && NumberHelper::isUnsigned($this->denominator)) {
            $this->numerator = NumberHelper::abs($this->numerator);
            $this->denominator = NumberHelper::abs($this->denominator);
            return;
        }
        if (NumberHelper::isUnsigned($this->numerator) || NumberHelper::isUnsigned($this->denominator)) {
            $this->numerator = NumberHelper::abs($this->numerator);
            $this->denominator = NumberHelper::abs($this->denominator);
            $this->signed = FALSE;
        }
    }

    /**
     * To string function
     *
     * @return string
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function __toString(): string
    {
        if (NumberHelper::compare($this->numerator, $this->denominator) === 0) {
            return '1';
        }
        if (NumberHelper::compare($this->numerator, $this->denominator) > 0) {
            $whole = bcdiv($this->numerator, $this->denominator);
            $mod = bcmod($this->numerator, $this->denominator);
            if ($mod === NumberHelper::ZERO) {
                return sprintf('%s%s', $this->signed ? '' : '-', $whole);
            }
            return sprintf('%s%s %s/%s',
                $this->signed ? '' : '-',
                $whole,
                $mod,
                $this->denominator
            );
        }

        if (NumberHelper::isZero($this->numerator)) {
            return NumberHelper::ZERO;
        }
        return sprintf('%s/%s',
            $this->getNumerator(),
            $this->getDenominator()
        );
    }

    /**
     * Get numerator
     *
     * @return string
     * @author Rsctd Team <super.rsctd@gmail.com>
     *
     */
    public function getNumerator(): string
    {
        return ($this->signed ? '' : '-').$this->numerator;
    }

    /**
     * Get denominator
     *
     * @return string
     * @author Rsctd Team <super.rsctd@gmail.com>
     *
     */
    public function getDenominator(): string
    {
        return $this->denominator;
    }


    /**
     * Simplify
     *
     * e.g. transform 2/4 into 1/2
     *
     * @return $this
     * @author Rsctd Team <super.rsctd@gmail.com>
     *
     */
    private function simplify(): Fraction
    {
        $gcd = NumberHelper::getGreatestCommonDivisor($this->numerator, $this->denominator);

        $this->numerator = bcdiv($this->numerator, $gcd);
        $this->denominator = bcdiv($this->denominator, $gcd);
        return $this;
    }

    /**
     * Multiply this fraction by a given fraction
     *
     * @param  Fraction  $fraction
     *
     * @return $this
     * @author Rsctd Team <super.rsctd@gmail.com>
     *
     */
    public function multiply(Fraction $fraction): Fraction
    {
        $numerator = bcmul($this->getNumerator(), $fraction->getNumerator());
        $denominator = bcmul($this->getDenominator(), $fraction->getDenominator());

        $this->numerator = $numerator;
        $this->denominator = $denominator;
        $this->getSigned();
        $this->simplify();
        return $this;
    }

    /**
     * Divide this fraction by a given fraction
     *
     * @param  Fraction  $fraction
     *
     * @return $this
     * @author Rsctd Team <super.rsctd@gmail.com>
     *
     */
    public function divide(Fraction $fraction): Fraction
    {
        $numerator = bcmul($this->getNumerator(), $fraction->getDenominator());
        $denominator = bcmul($this->getDenominator(), $fraction->getNumerator());

        $this->numerator = $numerator;
        $this->denominator = $denominator;
        $this->getSigned();
        $this->simplify();
        return $this;
    }

    /**
     * Add this fraction to a given fraction
     *
     * @param  Fraction  $fraction
     *
     * @return $this
     * @author Rsctd Team <super.rsctd@gmail.com>
     *
     */
    public function add(Fraction $fraction): Fraction
    {
        $numerator = bcadd(bcmul($this->getNumerator(), $fraction->getDenominator()),
            bcmul($fraction->getNumerator(), $this->getDenominator()));
        $denominator = bcmul($this->getDenominator(), $fraction->getDenominator());

        $this->numerator = $numerator;
        $this->denominator = $denominator;
        $this->getSigned();
        $this->simplify();
        return $this;
    }

    /**
     * Subtract a given fraction from this fraction
     *
     * @param  Fraction  $fraction
     *
     * @return $this
     * @author Rsctd Team <super.rsctd@gmail.com>
     *
     */
    public function subtract(Fraction $fraction): Fraction
    {
        $numerator = bcsub(bcmul($this->getNumerator(), $fraction->getDenominator()),
            bcmul($fraction->getNumerator(), $this->getDenominator()));
        $denominator = bcmul($this->getDenominator(), $fraction->getDenominator());

        $this->numerator = $numerator;
        $this->denominator = $denominator;
        $this->getSigned();
        $this->simplify();
        return $this;
    }

    /**
     * Whether or not this fraction is an integer
     *
     * @return bool
     * @author Rsctd Team <super.rsctd@gmail.com>
     *
     */
    public function isInteger(): bool
    {
        return '1' === $this->getDenominator();
    }

    /**
     * Get value as float
     *
     * @param  int  $scale
     *
     * @return float
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function toFloat(int $scale = NULL): float
    {
        $_scale = $scale;
        if (is_null($_scale)) {
            $_scale = 8;
        } else {
            if ($_scale < 0) {
                $_scale = 0;
            }
        }

        return (float)implode('', [
            $this->signed ? '' : '-',
            bcdiv($this->numerator, $this->denominator, $_scale),
        ]);
    }

    /**
     * isSameValueAs
     *
     * ValueObject comparison
     *
     * @param  Fraction  $fraction
     *
     * @return bool
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function isSameValueAs(Fraction $fraction): bool
    {
        return $this->getNumerator() === $fraction->getNumerator() && $this->getDenominator() === $fraction->getDenominator();
    }

    /**
     * Create from float
     *
     * @param  float  $float
     * @param  int    $scale
     *
     * @return Fraction
     * @author Rsctd Team <super.rsctd@gmail.com>
     *
     */
    public static function fromFloat(float $float, int $scale = 8): Fraction
    {
        if ($scale < 0) {
            $scale = 0;
        }
        $floatString = rtrim(sprintf('%.'.$scale.'F', $float), '0');

        $denominator = strstr($floatString, '.');
        $denominator = (int)str_pad('1', strlen($denominator), '0');
        $numerator = trim(str_replace('.', '', $floatString), '0');

        return new self($numerator, $denominator);
    }

    /**
     * Create from string, e.g.
     *
     *     * 1/3
     *     * 1/20
     *     * 40
     *     * 3 4/5
     *     * 20 34/67
     *
     * @param  string  $string
     *
     * @return Fraction
     * @author Rsctd Team <super.rsctd@gmail.com>
     *
     */
    public static function fromString(string $string): Fraction
    {
        // Integer
        if (preg_match('/^(-?\d+)$/', trim($string), $matches)) {
            return new self($matches[1]);
        }

        // Simple e.g. 3/4
        if (preg_match('/^(-?\d+)\/(\d+)$/', trim($string), $matches)) {
            return new self($matches[1], $matches[2]);
        }

        // Complex e.g. -2 3/4
        if (preg_match('/^(-?\d+) (\d+)\/(\d+)$/', trim($string), $matches)) {
            $numerator = bcmul($matches[1], $matches[3]);
            $sign = NumberHelper::isSigned($numerator);
            $numerator = bcadd(NumberHelper::abs($numerator), $matches[2]);
            return new self(($sign ? '' : '-').$numerator, $matches[3]);
        }

        throw new \InvalidArgumentException();
    }

}
