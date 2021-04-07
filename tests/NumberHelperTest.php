<?php

namespace Rsctd\Tests;

use PHPUnit\Framework\TestCase;
use Rsctd\HugeFraction\NumberHelper;

/**
 * Class NumberHelperTest
 *
 * @author Rsctd Team <super.rsctd@gmail.com>
 */
class NumberHelperTest extends TestCase
{
    /**
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function testValidate()
    {
        // True
        $this->assertTrue(NumberHelper::validate('0'));
        $this->assertTrue(NumberHelper::validate('0123456789'));
        $this->assertTrue(NumberHelper::validate('999999999'));
        $this->assertTrue(NumberHelper::validate(999));
        $this->assertTrue(NumberHelper::validate('-999999999'));
        $this->assertTrue(NumberHelper::validate('9999999999999999999999999999999999999999'));

        // False
        $this->assertFalse(NumberHelper::validate(''));
        $this->assertFalse(NumberHelper::validate('kk'));
        $this->assertFalse(NumberHelper::validate('5-'));
        $this->assertFalse(NumberHelper::validate('--999'));
        $this->assertFalse(NumberHelper::validate('99999.9999'));
        $this->assertFalse(NumberHelper::validate('-99999.9999'));
    }

    /**
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function testIsZero()
    {
        $this->assertFalse(NumberHelper::isZero('1'));
        $this->assertFalse(NumberHelper::isZero('100000'));
        $this->assertFalse(NumberHelper::isZero('9999999999999999999999999999999999999999'));
        $this->assertTrue(NumberHelper::isZero('0'));
        $this->assertTrue(NumberHelper::isZero('-0'));
    }

    /**
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function testIsSignNumber()
    {
        $this->assertTrue(NumberHelper::isSigned('1'));
        $this->assertTrue(NumberHelper::isSigned('100000'));
        $this->assertTrue(NumberHelper::isSigned('9999999999999999999999999999999999999999'));
        $this->assertFalse(NumberHelper::isSigned('0'));
        $this->assertFalse(NumberHelper::isSigned('-0'));
        $this->assertFalse(NumberHelper::isSigned('-100000'));
    }

    /**
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function testAbs()
    {
        $this->assertEquals('1', NumberHelper::abs('1'));
        $this->assertEquals('100000', NumberHelper::abs('100000'));
        $this->assertEquals('9999999999999999999999999999999999999999',
            NumberHelper::abs('-9999999999999999999999999999999999999999'));
        $this->assertEquals('0', NumberHelper::abs('0'));
        $this->assertEquals('0', NumberHelper::abs('-0'));
        $this->assertEquals('100000', NumberHelper::abs('-100000'));
    }

    /**
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function testCompare()
    {
        $this->assertEquals(0, NumberHelper::compare('9999999999999999999999999999999999999999',
            '9999999999999999999999999999999999999999'));
        $this->assertEquals(0, NumberHelper::compare('-9999999999999999999999999999999999999999',
            '-9999999999999999999999999999999999999999'));
        $this->assertEquals(1, NumberHelper::compare('9999999999999999999999999999999999999999',
            '-9999999999999999999999999999999999999999'));
        $this->assertEquals(-1, NumberHelper::compare('-9999999999999999999999999999999999999999',
            '9999999999999999999999999999999999999999'));
        $this->assertEquals(-1, NumberHelper::compare('9999999999999999999999999999998999999999',
            '9999999999999999999999999999999999999999'));
        $this->assertEquals(1, NumberHelper::compare('9999999999999999999999999999998999999999',
            '9999999999999999999999899999999999999999'));
    }

    /**
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function testFloor()
    {
        $this->assertEquals('99999999999999', NumberHelper::floor('99999999999999.99999999999999999999999999'));
        $this->assertEquals('99999999999999', NumberHelper::floor('99999999999999'));
        $this->assertEquals('-999999999999999999999',
            NumberHelper::floor('-999999999999999999999.9999999999999999999'));
        $this->assertEquals('-999999999999999999999', NumberHelper::floor('-999999999999999999999'));
    }

    /**
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function testMin()
    {
        $this->assertEquals('1', NumberHelper::min('1', '2'));
        $this->assertEquals('-2', NumberHelper::min('1', '-2'));
        $this->assertEquals('2', NumberHelper::min('2', '2'));
        $this->assertEquals('2', NumberHelper::min('12', '2'));
        $this->assertEquals('-12', NumberHelper::min('-12', '2'));
    }

    /**
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function testMax()
    {
        $this->assertEquals('2', NumberHelper::max('1', '2'));
        $this->assertEquals('1', NumberHelper::max('1', '-2'));
        $this->assertEquals('2', NumberHelper::max('2', '2'));
        $this->assertEquals('12', NumberHelper::max('12', '2'));
        $this->assertEquals('2', NumberHelper::max('-12', '2'));
    }


    /**
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function testGetGreatestCommonDivisor()
    {
        $this->assertEquals('1', NumberHelper::getGreatestCommonDivisor('1', '2'));
        $this->assertEquals('1', NumberHelper::getGreatestCommonDivisor('0', '2'));
        $this->assertEquals('2', NumberHelper::getGreatestCommonDivisor('2', '2'));
        $this->assertEquals('2', NumberHelper::getGreatestCommonDivisor('12', '2'));
        $this->assertEquals('2', NumberHelper::getGreatestCommonDivisor('12', '2'));
        $this->assertEquals('4', NumberHelper::getGreatestCommonDivisor('12', '8'));
        $this->assertEquals('30', NumberHelper::getGreatestCommonDivisor('120', '90'));
    }
}
