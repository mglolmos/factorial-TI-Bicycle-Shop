<?php
namespace App\Domain;

use App\Domain\Utilities\Id;
use App\Domain\Utilities\Name;

class Product {
    private Id $id;

    private Name $name;

    public function __construct($id, $name)
    {
        $this->id = new Id($id);
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
}