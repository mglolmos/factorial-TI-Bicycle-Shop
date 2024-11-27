<?php
namespace App\Domain;

use App\Domain\Utilities\IdString;
use App\Domain\Utilities\Name;

class Collection
{
    private IdString $id;

    private Name $name;

    public function __construct(string $name) {
        $this->name = new Name($name);
        $this->id = new IdString($this->name->getName());
    }

    public function getId(): string {
        return $this->id->getValue();
    }

    public function getName(): string {
        return $this->name->getName();
    }
}