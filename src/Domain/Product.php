<?php
namespace App\Domain;

use App\Domain\Utilities\Uuid;
use App\Domain\Utilities\Name;

class Product {
    private Uuid $id;

    private Name $name;

    private $collections = [];

    private $components = [];

    public function __construct($id, $name)
    {
        $this->id = new Uuid($id);
        $this->name = new Name($name);
    }

    public function getId()
    {
        return $this->id->getValue();
    }

    public function getName()
    {
        return $this->name->getName();
    }


    public function addCollection(Collection $collection)
    {
        $this->collections[$collection->getId()] = $collection;
    }

    public function getCollectionName($collection_id): string
    {
        return $this->collections[$collection_id]->getName();
    }

    public function addComponent($collection_id, Component $component) {
        if (!array_key_exists($collection_id, $this->collections)) {
            throw new ComponentInvalidException("Collection '$collection_id' does not exist");
        }
        $this->components[$collection_id][$component->getId()] = $component;
    }

    public function getComponentName($collection_id, $component_id): string
    {
        return $this->components[$collection_id][$component_id]->getName();
    }

    public function getComponentPrice($collection_id, $component_id): string
    {
        return $this->components[$collection_id][$component_id]->getPrice();
    }

    public function isComponentInStock($collection_id, $component_id): bool
    {
        return $this->components[$collection_id][$component_id]->isInStock();
    }

}