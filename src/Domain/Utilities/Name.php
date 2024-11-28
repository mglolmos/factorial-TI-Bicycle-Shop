<?php
namespace App\Domain\Utilities;

class Name {

    private string $name;

    public function __construct(string $name)
    {
        $this->setName($name);
    }
    public function getNameValue(): string
    {
        return $this->name;
    }

    private function setName(string $name): void
    {
        if (empty(trim($name))) {
            throw new NameInvalidException('Name cannot be empty');
        }
        $name_trimmed = trim($name);
        $length = strlen($name);
        if ($length < 3 || $length > 100) {
            throw new NameInvalidException('Name must be between 3 and 100 characters');
        }
        $this->name = $name_trimmed;
    }
}