<?php
namespace App\Domain;

use App\Domain\Utilities\Name;

class Product {
    private $id;

    private Name $name;

    public function __construct($id, $name) {
        $this->setId($id);
        $this->name = new Name($name);
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name->getName();
    }

    public function setId($id) {
        if ($id <= 0) {
            throw new ProductInvalidException();
        }
        $this->id = $id;
    }

}