<?php
namespace App\Tests\Unit\Domain;

use App\Domain\Collection;
use App\Domain\Component;
use App\Domain\ComponentInvalidException;
use App\Domain\Utilities\Id;
use App\Domain\Utilities\Name;
use App\Domain\Utilities\Price;

use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    private Name $name;

    protected function setUp(): void
    {
        // Mocking Name class
        $this->name = $this->createMock(Name::class);
        $this->name->method('getNameValue')->willReturn('Sample Collection');
    }

    public function testCollectionCreation()
    {
        // Arrange
        $collection = new Collection($this->name);

        // Act
        $id = $collection->getId();

        // Assert
        $this->assertEquals('Sample Collection', $collection->getName()->getNameValue());
        $this->assertEquals($id->getValue(), (new Id('Sample Collection'))->getValue()); // Assuming Id is created from the name
    }

    public function testAddComponent()
    {
        // Arrange
        $collection = new Collection($this->name);
        $component = $this->createMock(Component::class);
        $component->method('getId')->willReturn(new Id('component1'));
        $component->method('getName')->willReturn(new Name('Sample Component'));

        // Act
        $collection->addComponent($component);

        // Assert
        $this->assertEquals('Sample Component', $collection->getComponentName(new Id('component1'))->getNameValue());
    }

    public function testGetComponentThrowsExceptionForInvalidId()
    {
        // Arrange
        $collection = new Collection($this->name);
        $componentId = new Id('invalid_component');

        // Act & Assert
        $this->expectException(ComponentInvalidException::class);
        $this->expectExceptionMessage("Component '$componentId' does not exist");

        $collection->getComponent($componentId);
    }

    public function testAddIncompatibleComponent()
    {
        // Arrange
        $collection = new Collection($this->name);
        $componentId = new Id('component1');
        $incompatibleCollectionId = new Id('collection2');
        $incompatibleComponentId = new Id('component2');

        // Mocking the component to add and expects
        $component = $this->createMock(Component::class);
        $component->expects($this->once())->method('getId')->willReturn($componentId);

        // Act
        $collection->addComponent($component);
        $collection->addIncompatibleComponent($componentId, $incompatibleCollectionId, $incompatibleComponentId);

    }

    public function testAddSelfIncompatibleComponentThrowsException()
    {
        // Arrange
        $collection = new Collection($this->name);
        $componentId = new Id('component1');

        // Mocking the component to add
        $component = $this->createMock(Component::class);
        $component->method('getId')->willReturn($componentId);

        // Act
        $collection->addComponent($component);

        // Act & Assert
        $this->expectException(ComponentInvalidException::class);
        $this->expectExceptionMessage("Component collection: '{$collection->getId()->getValue()}' with component: '{$componentId}' can not be incompatible with itself.");

        $collection->addIncompatibleComponent($componentId, $collection->getId(), $componentId);
    }

}
