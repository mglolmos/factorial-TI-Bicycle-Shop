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

    public function __construct(string $name, $price) {
        $this->name = new Name($name);
        $this->id = new Id($this->name->getName());
        $this->price = new Price($price);
        $this->is_in_stock = true;
    }

    public function getId() {
        return $this->id->getValue();
    }

    public function getName(): string{
        return $this->name->getName();
    }

    public function getPrice(): int {
        return $this->price->getValue();
    }

    public function isInStock(): bool {
        return $this->is_in_stock;
    }
}