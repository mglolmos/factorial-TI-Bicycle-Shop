<?php
namespace App\Domain;

use App\Domain\Utilities\Id;
use App\Domain\Utilities\Price;
use App\Domain\Utilities\Uuid;
use App\Domain\Utilities\Name;

class Product {
    private Uuid $id;

    private Name $name;

    /**
     * @var Collection[]
     */
    private array $collections = [];

//    private array $restrictions = [];

    public function __construct(Uuid $id, Name $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }


    public function addCollection(Collection $collection)
    {
        $this->collections[$collection->getIdKey()] = $collection;
    }

    public function getCollectionName(Id $collection_id): Name
    {
        return $this->collections[$collection_id->getValue()]->getName();
    }

    public function addComponent(Id $collection_id, Component $component) {
        $this->checkCollectionExists($collection_id);
        $this->collections[$collection_id->getValue()]->addComponent($component);
    }

    public function getComponentName(Id $collection_id, Id $component_id): Name
    {
        $this->checkCollectionExists($collection_id);
        return $this->collections[$collection_id->getValue()]->getComponentName($component_id);
    }
    public function isComponentInStock(Id $collection_id, Id $component_id): bool
    {
        $this->checkCollectionExists($collection_id);
        return $this->collections[$collection_id->getValue()]->isComponentInStock($component_id);
    }


//    public function addRestriction(Id $component_id1, Id $component_id2)
//    {
//        $this->restrictions[$component_id1->getValue()] = $component_id2->getValue();
//    }

    public function getComponentPrice(Id $collection_id, Id $component_id): Price
    {
        $this->checkCollectionExists($collection_id);
        return $this->collections[$collection_id->getValue()]->getComponentPrice($component_id);
    }

    private function checkCollectionExists(Id $collection_id)
    {
        if (!array_key_exists($collection_id->getValue(), $this->collections)) {
            throw new ComponentInvalidException("Collection '$collection_id' does not exist");
        }

    }

}