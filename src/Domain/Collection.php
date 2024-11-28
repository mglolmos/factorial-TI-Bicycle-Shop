<?php
namespace App\Domain;

use App\Domain\Utilities\Id;
use App\Domain\Utilities\Name;
use App\Domain\Utilities\Price;

class Collection
{
    private Id $id;

    private Name $name;
    /**
     * @var Component[]  // PHPDoc para indicar que es un array de objetos Collection
     */
    private $components = [];

    public function __construct(Name $name) {
        $this->name = $name;
        $this->id = new Id($this->name->getNameValue());
    }

    public function getId(): Id {
        return $this->id;
    }

    public function getIdKey(): string {
        return $this->id->getValue();
    }

    public function getName(): Name {
        return $this->name;
    }

    public function addComponent(Component $component): void
    {
        $this->components[$component->getId()->getValue()] = $component;
    }

    public function getComponent(Id $componentId): Component
    {
        return $this->components[$componentId->getValue()];
    }

    public function addIncompatibleComponent(Id $component_id, Id $collection_id2, Id $component_id2): void
    {
        $this->components[$component_id->getValue()]->addIncompatibleComponent($collection_id2, $component_id2);
    }
    public function getComponentName(Id $componentId): Name
    {
        return $this->components[$componentId->getValue()]->getName();
    }

    public function getComponentPrice(Id $componentId): Price
    {
        return $this->components[$componentId->getValue()]->getPrice();
    }

    public function isComponentInStock(Id $componentId): bool
    {
        return $this->components[$componentId->getValue()]->isInStock();
    }
}