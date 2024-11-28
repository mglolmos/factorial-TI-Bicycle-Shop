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
     * @var Component[]
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

    /**
     * @throws ComponentInvalidException
     */
    public function getComponent(Id $component_id): Component
    {
        $this->checkComponentExists($component_id);
        return $this->components[$component_id->getValue()];
    }

    public function addIncompatibleComponent(Id $component_id, Id $collection_id2, Id $component_id2): void
    {
        $this->checkComponentExists($component_id);
        $this->components[$component_id->getValue()]->addIncompatibleComponent($collection_id2, $component_id2);
    }


    public function getComponentName(Id $component_id): Name
    {
        $this->checkComponentExists($component_id);
        return $this->components[$component_id->getValue()]->getName();
    }

    public function getComponentPrice(Id $component_id): Price
    {
        $this->checkComponentExists($component_id);
        return $this->components[$component_id->getValue()]->getPrice();
    }

    public function isComponentInStock(Id $component_id): bool
    {
        $this->checkComponentExists($component_id);
        return $this->components[$component_id->getValue()]->isInStock();
    }

    public function markComponentIsInStock(Id $component_id): void
    {
        $this->checkComponentExists($component_id);
        $this->components[$component_id->getValue()]->markIsInStock();
    }

    public function markComponentIsOutOfStock(Id $component_id): void
    {
        $this->checkComponentExists($component_id);
        $this->components[$component_id->getValue()]->markIsOutOfStock();
    }


    private function checkComponentExists(Id $component_id): void
    {
        if (!array_key_exists($component_id->getValue(), $this->components)) {
            throw new ComponentInvalidException("Component '$component_id' does not exist");
        }
    }
}