<?php
namespace App\Domain;

use App\Domain\Utilities\Uuid;
use App\Domain\Utilities\Name;

class Product {
    private Uuid $id;

    private Name $name;

    private $collections = [];

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

}