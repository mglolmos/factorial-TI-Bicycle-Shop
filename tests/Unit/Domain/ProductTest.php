<?php
namespace Tests\Unit\Domain;

use App\Domain\Collection;
use App\Domain\CollectionInvalidException;
use App\Domain\Component;
use App\Domain\ComponentInvalidException;
use App\Domain\Product;
use App\Domain\Utilities\Id;
use App\Domain\Utilities\Name;
use App\Domain\Utilities\Price;
use App\Domain\Utilities\Uuid;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testProductCreation()
    {
        // Arrange
        $id = new Uuid('550e8400-e29b-41d4-a716-446655440000');
        $productName = new Name('Sample Product');

        // Act
        $product = new Product($id, $productName);

        // Assert
        $this->assertEquals($id, $product->getId());
        $this->assertEquals($productName, $product->getName());
    }

    public function testAddCollection()
    {
        // Arrange
        $product = new Product(new Uuid('550e8400-e29b-41d4-a716-446655440000'), new Name('Sample Product'));
        $collection = new Collection(new Name('Sample Collection'));

        // Act
        $product->addCollection($collection);

        // Assert
        $this->assertEquals(new Name('Sample Collection'), $product->getCollectionName(new Id('sample_collection')));
    }

    public function testAddComponent()
    {
        // Arrange
        $product = new Product(new Uuid('550e8400-e29b-41d4-a716-446655440000'), new Name('Sample Product'));
        $collection = new Collection(new Name('Sample Collection'));
        $component = new Component(new Name('Sample Component'), Price::fromInt(100));

        // Act
        $product->addCollection($collection);
        $product->addComponent($collection->getId(), $component);

        // Assert
        $this->assertEquals(new Name('Sample Component'), $product->getComponentName($collection->getId(), $component->getId()));
        $this->assertEquals(Price::fromInt(100), $product->getComponentPrice($collection->getId(), $component->getId()));
        $this->assertTrue($product->isComponentInStock($collection->getId(), $component->getId()));
    }

    public function testAddComponentWithoutCollectionShouldThrowException()
    {

        // Arrange
        $product = new Product(new Uuid('550e8400-e29b-41d4-a716-446655440000'), new Name('Sample Product'));
        $component = new Component(new Name('Sample Component'), Price::fromInt(100));

        // Act & Assert
        $this->expectException(CollectionInvalidException::class);
        $product->addComponent(new Id('collection_not_exists_id'), $component);
    }
}