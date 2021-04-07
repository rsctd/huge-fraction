<?php

namespace Rsctd\Tests;

use Rsctd\HugeFraction\Fraction;
use PHPUnit\Framework\TestCase;

/**
 * FractionTest
 *
 * @author Rsctd Team <super.rsctd@gmail.com>
 */
class FractionTest extends TestCase
{
    /**
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function testConstructor()
    {
        $fraction = new Fraction(1, 2);

        $this->assertEquals('1', $fraction->getNumerator());
        $this->assertEquals('2', $fraction->getDenominator());
        $this->assertEquals('1/2', $fraction);

        $this->assertEquals('1 1/49', new Fraction(100, 98));
        $this->assertEquals('1', new Fraction('1225398734534784353454', '1225398734534784353454'));
        $this->assertEquals('100000000010000000001', new Fraction('999999999999999999999999999999', '9999999999'));
        $this->assertEquals('1/2', new Fraction('3', '6'));
        $this->assertEquals('-1/2', new Fraction('-3', '6'));
        $this->assertEquals('-1/2', new Fraction('3', '-6'));
        $this->assertEquals('-1 1/2', new Fraction('9', '-6'));
    }

    /**
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function testMultiple()
    {
        $fraction = new Fraction(1, 2);

        $this->assertEquals('1/4', $fraction->multiply($fraction));
        $this->assertEquals('1/4', (new Fraction('3', '6'))->multiply(new Fraction(1, 2)));
    }

    /**
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function testDivide()
    {
        $fraction = new Fraction(1, 2);

        $this->assertEquals('1', $fraction->divide($fraction));
        $this->assertEquals('1', (new Fraction('3', '6'))->divide(new Fraction(1, 2)));
        $this->assertEquals('1 1/9', (new Fraction('5', '6'))->divide(new Fraction(3, 4)));
    }

    /**
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function testAdd()
    {
        $fraction = new Fraction(1, 2);

        $this->assertEquals('1', $fraction->add($fraction));
        $this->assertEquals('1', (new Fraction('3', '6'))->add(new Fraction(1, 2)));
        $this->assertEquals('1 7/12', (new Fraction('5', '6'))->add(new Fraction(3, 4)));
    }

    /**
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function testSub()
    {
        $fraction = new Fraction(1, 2);

        $this->assertEquals('0', $fraction->subtract($fraction));
        $this->assertEquals('0', (new Fraction('3', '6'))->subtract(new Fraction(1, 2)));
        $this->assertEquals('1/12', (new Fraction('5', '6'))->subtract(new Fraction(3, 4)));
    }

    /**
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function testIsInteger()
    {
        $this->assertFalse((new Fraction(5, 2))->isInteger());
        $this->assertFalse((new Fraction(5, 3))->isInteger());
        $this->assertFalse((new Fraction(5, 4))->isInteger());
        $this->assertTrue((new Fraction(5, 5))->isInteger());
        $this->assertTrue((new Fraction(25, 5))->isInteger());
    }

    /**
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function testFromFloat()
    {
        $fraction = Fraction::fromFloat(5.0, 10);
        $this->assertEquals('5', $fraction->getNumerator());
        $this->assertEquals('1', $fraction->getDenominator());
        $this->assertEquals('5', $fraction);

        $fraction = Fraction::fromFloat(6 / 7, 10);
        $this->assertEquals('8571428571', $fraction->getNumerator());
        $this->assertEquals('10000000000', $fraction->getDenominator());
        $this->assertEquals('8571428571/10000000000', $fraction);

        $pi = Fraction::fromFloat(M_PI, 10);
        $this->assertEquals('3926990817', $pi->getNumerator());
        $this->assertEquals('1250000000', $pi->getDenominator());
        $this->assertEquals('3 176990817/1250000000', $pi);
    }

    /**
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function testToFloat()
    {
        $fraction = Fraction::fromFloat(5.0, 10);
        $this->assertEquals('5', $fraction->toFloat());
        $this->assertEquals('5.00', $fraction->toFloat(2));

        $fraction = Fraction::fromString('-5');
        $this->assertEquals('-5', $fraction->toFloat());
        $this->assertEquals('-5.00', $fraction->toFloat(2));

        $fraction = Fraction::fromFloat(6 / 7, 10);
        $this->assertEquals('0.8571428571', $fraction->toFloat(10));

        $fraction = Fraction::fromString('-3/20');
        $this->assertEquals('-0.15', $fraction->toFloat(10));

        $pi = Fraction::fromFloat(M_PI, 10);
        $this->assertEquals('3.14159265', $pi->toFloat());
        $this->assertEquals('3.14', $pi->toFloat(2));
    }

    /**
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function testFromString()
    {
        $fraction = Fraction::fromString('40');
        $this->assertEquals('40', $fraction->getNumerator());
        $this->assertEquals('1', $fraction->getDenominator());
        $this->assertEquals('40', $fraction);

        $fraction = Fraction::fromString('1/3');
        $this->assertEquals('1', $fraction->getNumerator());
        $this->assertEquals('3', $fraction->getDenominator());
        $this->assertEquals('1/3', $fraction);

        $fraction = Fraction::fromString('-3/20');
        $this->assertEquals('-3', $fraction->getNumerator());
        $this->assertEquals('20', $fraction->getDenominator());
        $this->assertEquals('-3/20', $fraction);

        $fraction = Fraction::fromString('3 4/5');
        $this->assertEquals('19', $fraction->getNumerator());
        $this->assertEquals('5', $fraction->getDenominator());
        $this->assertEquals('3 4/5', $fraction);

        $fraction = Fraction::fromString('-20 34/67');
        $this->assertEquals('-1374', $fraction->getNumerator());
        $this->assertEquals('67', $fraction->getDenominator());
        $this->assertEquals('-20 34/67', $fraction);
    }

    /**
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function testIsSameValueAs()
    {
        $fraction1 = Fraction::fromString('40');
        $fraction2 = Fraction::fromString('1/3');
        $this->assertFalse($fraction1->isSameValueAs($fraction2));

        $fraction1 = Fraction::fromString('40');
        $fraction2 = Fraction::fromString('40/1');
        $this->assertTrue($fraction1->isSameValueAs($fraction2));

        $fraction1 = Fraction::fromString('-2 3/5');
        $fraction2 = Fraction::fromFloat('-2.6');
        $this->assertTrue($fraction1->isSameValueAs($fraction2));
    }
}
