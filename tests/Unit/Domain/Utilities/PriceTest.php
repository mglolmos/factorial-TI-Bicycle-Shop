<?php
namespace App\Tests\Unit\Domain\Utilities;

use App\Domain\Utilities\Price;
use App\Domain\Utilities\PriceInvalidException;
use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
    public function testValidPriceCreation()
    {
        $price = Price::fromString("100");
        $this->assertEquals(100, $price->getValue());
    }

    public function testPriceCannotBeNegative()
    {
        $this->expectException(PriceInvalidException::class);
        $this->expectExceptionMessage("Price cannot be less than zero");

        Price::fromString("-50");
    }

    public function testPriceEquals()
    {
        $price1 = Price::fromString("100");
        $price2 = Price::fromString("100");
        $price3 = Price::fromString("200");

        $this->assertTrue($price1->equals($price2));
        $this->assertFalse($price1->equals($price3));
    }

    public function testPriceWithStringInput()
    {
        $price = Price::fromString("150");
        $this->assertEquals(150, $price->getValue());
    }
}