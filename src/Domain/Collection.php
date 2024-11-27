<?php
namespace App\Domain;

use App\Domain\Utilities\Id;
use App\Domain\Utilities\Name;

class Collection
{
    private Id $id;

    private Name $name;

    private $components = [];

    public function __construct(string $name) {
        $this->name = new Name($name);
        $this->id = new Id($this->name->getName());
    }

    public function getId(): string {
        return $this->id->getValue();
    }

    public function getName(): string {
        return $this->name->getName();
    }

    public function addComponent(Component $component): void {
        $this->components[$component->getId()] = $component;
    }

    public function getComponentName($componentId) {
        return $this->components[$componentId]->getName();
    }

    public function getComponentPrice($componentId) {
        return $this->components[$componentId]->getPrice();
    }

    public function isComponentInStock($componentId) {
        return $this->components[$componentId]->isInStock();
    }
}