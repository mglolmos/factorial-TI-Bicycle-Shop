<?php
namespace App\Domain;

use App\Domain\Utilities\Uuid;
use App\Domain\Utilities\Name;

class Product {
    private Uuid $id;

    private Name $name;

    private array $collections = [];

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
        $this->checkCollectionExists($collection_id);
        $this->collections[$collection_id]->addComponent($component);
    }

    public function getComponentName($collection_id, $component_id): string
    {
        $this->checkCollectionExists($collection_id);
        return $this->collections[$collection_id]->getComponentName($component_id);
    }

    public function getComponentPrice($collection_id, $component_id): string
    {
        $this->checkCollectionExists($collection_id);
        return $this->collections[$collection_id]->getComponentPrice($component_id);
    }

    public function isComponentInStock($collection_id, $component_id): bool
    {
        $this->checkCollectionExists($collection_id);
        return $this->collections[$collection_id]->isComponentInStock($component_id);
    }


    private function checkCollectionExists($collection_id)
    {
        if (!array_key_exists($collection_id, $this->collections)) {
            throw new ComponentInvalidException("Collection '$collection_id' does not exist");
        }

    }

}