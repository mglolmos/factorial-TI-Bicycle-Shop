<?php
namespace App\Domain;

use App\Domain\Utilities\Id;
use App\Domain\Utilities\Name;

class Collection
{
    private Id $id;

    private Name $name;

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
}