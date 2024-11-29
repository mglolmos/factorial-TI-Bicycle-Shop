<?php
namespace App\Tests\Unit\Domain;

use App\Domain\Component;
use App\Domain\ComponentInvalidException;
use App\Domain\Utilities\Id;
use App\Domain\Utilities\Name;
use App\Domain\Utilities\Price;

use PHPUnit\Framework\TestCase;

class ComponentTest extends TestCase
{
    private Name $name;
    private Price $price;

    protected function setUp(): void
    {
        // Mocking Name and Price classes
        $this->name = $this->createMock(Name::class);
        $this->price = $this->createMock(Price::class);
    }

    public function testComponentCreation()
    {
        // Arrange
        $this->name->method('getNameValue')->willReturn('Sample Component');
        $this->price->method('getValue')->willReturn(19);

        // Act
        $component = new Component($this->name, $this->price);

        // Assert
        $this->assertEquals('Sample Component', $component->getName()->getNameValue());
        $this->assertEquals(19, $component->getPrice()->getValue());
        $this->assertTrue($component->isInStock());
    }

    public function testMarkIsOutOfStock()
    {
        // Arrange
        $component = new Component($this->name, $this->price);

        // Act
        $component->markIsOutOfStock();

        // Assert
        $this->assertFalse($component->isInStock());
    }

    public function testMarkIsInStock()
    {
        // Arrange
        $component = new Component($this->name, $this->price);
        $component->markIsOutOfStock();

        // Act
        $component->markIsInStock();

        // Assert
        $this->assertTrue($component->isInStock());
    }

    public function testAddIncompatibleComponent()
    {
        // Arrange
        $component = new Component($this->name, $this->price);
        $collectionId = new Id('collection1');
        $componentId = new Id('component2');

        // Act
        $component->addIncompatibleComponent($collectionId, $componentId);

        // Assert
        $this->assertCount(1, $component->getIncompatibleComponents());
        $this->assertArrayHasKey('collection1_component2', $component->getIncompatibleComponents());
    }
}
