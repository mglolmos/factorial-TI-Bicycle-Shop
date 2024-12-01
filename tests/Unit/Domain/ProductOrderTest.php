<?php
namespace App\Tests\Unit\Domain;

use App\Domain\CollectionInvalidException;
use App\Domain\Component;
use App\Domain\InvalidProductOrderException;
use App\Domain\Product;
use App\Domain\ProductOrder;
use App\Domain\Utilities\Price;
use PHPUnit\Framework\TestCase;

class ProductOrderTest extends TestCase
{
    public function testValidOrder()
    {
        // Arrange
        $product = $this->createMock(Product::class);
        $component1 = $this->createMock(Component::class);
        $component2 = $this->createMock(Component::class);

        // Mocking component methods
        $component1->method('isInStock')->willReturn(true);
        $component1->method('isCompatibleWith')->willReturn(true);
        $component1->method('getPrice')->willReturn(Price::fromInt(100));
        $component2->method('isInStock')->willReturn(true);
        $component2->method('isCompatibleWith')->willReturn(true);
        $component2->method('getPrice')->willReturn(Price::fromInt(150));

        // Mocking product methods
        $product->method('getComponent')->willReturn($component1, $component2);


        // Create an order with valid components
        $componentsSelected = [
            'collection1' => 'component1',
            'collection2' => 'component2',
        ];

        $order = new ProductOrder($product, $componentsSelected);

        // Act
        $result = $order->checkIfOrderHasInvalidComponents();

        // Assert
        $this->assertTrue($result);
    }

    public function testInvalidOrderDueComponentOutOfStock()
    {
        // Arrange
        $product = $this->createMock(Product::class);
        $component1 = $this->createMock(Component::class);

        // Mocking component methods
        $component1->method('isInStock')->willReturn(false); // Out of stock
        $component1->method('isCompatibleWith')->willReturn(true);
        $component1->method('getPrice')->willReturn(Price::fromInt(100));

        // Mocking product methods
        $product->method('getComponent')->willReturn($component1);

        // Create an order with invalid components
        $componentsSelected = [
            'collection1' => 'component1',
        ];

        $order = new ProductOrder($product, $componentsSelected);

        // Act
        $result = $order->checkIfOrderHasInvalidComponents();

        // Assert
        $this->assertFalse($result);
    }


    public function testInvalidOrderDueToIncompatibility()
    {
        // Arrange
        $product = $this->createMock(Product::class);
        $component1 = $this->createMock(Component::class);

        // Mocking component methods
        $component1->method('isInStock')->willReturn(true);
        $component1->method('isCompatibleWith')->willReturn(false); // Incompatible
        $component1->method('getPrice')->willReturn(Price::fromInt(100));

        // Mocking product methods
        $product->method('getComponent')->willReturn($component1);

        // Create an order with invalid components
        $componentsSelected = [
            'collection1' => 'component1',
        ];

        $order = new ProductOrder($product, $componentsSelected);

        // Act
        $result = $order->checkIfOrderHasInvalidComponents();

        // Assert
        $this->assertFalse($result);
    }

    public function testGetPrice()
    {
        // Arrange
        $product = $this->createMock(Product::class);
        $component1 = $this->createMock(Component::class);
        $component2 = $this->createMock(Component::class);

        // Mocking component methods
        $component1->method('getPrice')->willReturn(Price::fromInt(100));
        $component2->method('getPrice')->willReturn(Price::fromInt(150));

        // Mocking product methods
        $product->method('getComponent')->willReturn($component1, $component2);

        // Create an order with components
        $componentsSelected = [
            'collection1' => 'component1',
            'collection2' => 'component2',
        ];

        $order = new ProductOrder($product, $componentsSelected);

        // Act
        $price = $order->getPrice();

        // Assert
        $this->assertEquals(250, $price->getValue());
    }

    public function testInvalidCollectionThrowsException()
    {
        // Arrange
        $product = $this->createMock(Product::class);

        // Mocking product methods to throw exceptions
        $product->method('getComponent')
            ->willThrowException(new CollectionInvalidException("Collection not found"));

        // Create an order with invalid components
        $componentsSelected = [
            'invalidCollection' => 'component1',
        ];

        $order = new ProductOrder($product, $componentsSelected);

        // Act & Assert
        $this->expectException(InvalidProductOrderException::class);
        $order->checkIfOrderHasInvalidComponents();
    }
}