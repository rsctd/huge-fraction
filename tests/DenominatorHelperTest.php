<?php

namespace Rsctd\Tests;

use PHPUnit\Framework\TestCase;
use Rsctd\HugeFraction\DenominatorHelper;

/**
 * Class DenominatorHelperTest
 *
 * @author Rsctd Team <super.rsctd@gmail.com>
 */
class DenominatorHelperTest extends TestCase
{
    /**
     * @author Rsctd Team <super.rsctd@gmail.com>
     */
    public function testValidate()
    {
        // True
        $this->assertTrue(DenominatorHelper::validate('0123456789'));
        $this->assertTrue(DenominatorHelper::validate('999999999'));
        $this->assertTrue(DenominatorHelper::validate(999));
        $this->assertTrue(DenominatorHelper::validate('-999999999'));
        $this->assertTrue(DenominatorHelper::validate('9999999999999999999999999999999999999999'));

        // False
        $this->assertFalse(DenominatorHelper::validate('0'));
    }
}
