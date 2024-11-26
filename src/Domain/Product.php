<?php
namespace App\Domain;

class Product {
    private $id;

    private $name;

    public function __construct($id, $name) {
        $this->setId($id);
        $this->setName($name);
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setId($id) {
        if ($id <= 0) {
            throw new ProductInvalidException();
        }
        $this->id = $id;
    }

    public function setName($name) {
        if (empty($name)) {
            throw new ProductInvalidException();
        }
        $this->name = $name;
    }
}