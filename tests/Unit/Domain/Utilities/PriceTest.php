<?php
namespace App\Tests\Unit\Domain\Utilities;

use App\Domain\Utilities\Price;
use App\Domain\Utilities\PriceInvalidException;
use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
    public function testValidPriceCreation()
    {
        $price = new Price("100");
        $this->assertEquals(100, $price->getValue());
    }

    public function testPriceCannotBeNegative()
    {
        $this->expectException(PriceInvalidException::class);
        $this->expectExceptionMessage("Price cannot be less than zero");

        new Price("-50");
    }

    public function testPriceEquals()
    {
        $price1 = new Price("100");
        $price2 = new Price("100");
        $price3 = new Price("200");

        $this->assertTrue($price1->equals($price2));
        $this->assertFalse($price1->equals($price3));
    }

    public function testPriceWithStringInput()
    {
        $price = new Price("150");
        $this->assertEquals(150, $price->getValue());
    }
}