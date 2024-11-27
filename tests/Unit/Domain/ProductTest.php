<?php
namespace Tests\Unit\Domain;

use App\Domain\Collection;
use App\Domain\Component;
use App\Domain\Product;
use App\Domain\Utilities\Name;
use App\Domain\Utilities\Uuid;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{

    public function testProductCreation()
    {
        $id = '550e8400-e29b-41d4-a716-446655440000';
        $productName = 'Sample Product';

        $product = new Product($id, $productName);

        $this->assertEquals($id, $product->getId());
        $this->assertEquals($productName, $product->getName());
    }

    public function testAddCollection()
    {
        $product = new Product('550e8400-e29b-41d4-a716-446655440000', 'Sample Product');
        $collection = new Collection('Sample Collection');

        $product->addCollection($collection);

        $this->assertEquals('Sample Collection', $product->getCollectionName('sample_collection'));
    }

    public function testAddComponent()
    {
        $product = new Product('550e8400-e29b-41d4-a716-446655440000', 'Sample Product');
        $collection = new Collection('Sample Collection');
        $component = new Component('Sample Component', 100);

        $product->addComponent($collection->getId(), $component);

        $this->assertEquals('Sample Component', $product->getComponentName($collection->getId(), $component->getId()));
        $this->assertEquals(100, $product->getComponentPrice($collection->getId(), $component->getId()));
        $this->assertTrue($product->isComponentInStock($collection->getId(), $component->getId()));
    }

    

}