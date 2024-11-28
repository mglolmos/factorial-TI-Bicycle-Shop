<?php
namespace App\Domain;

use App\Domain\Utilities\Id;
use App\Domain\Utilities\Name;
use App\Domain\Utilities\Price;

class Component
{
    private Id $id;
    private Name $name;

    private Price $price;

    private bool $is_in_stock;

    public function __construct(Name $name, Price $price) {
        $this->name = $name;
        $this->id = new Id($this->name->getNameValue());
        $this->price = $price;
        $this->is_in_stock = true;
    }

    public function getId(): Id {
        return $this->id;
    }

    public function getName(): Name {
        return $this->name;
    }

    public function getPrice(): Price {
        return $this->price;
    }

    public function isInStock(): bool {
        return $this->is_in_stock;
    }
}