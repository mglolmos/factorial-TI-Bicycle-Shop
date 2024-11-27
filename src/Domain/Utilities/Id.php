<?php
namespace App\Domain\Utilities;


class Id {

    private string $id;

    public function __construct(string $id)
    {
        $this->setId($id);
    }

    public static function generate($id): self
    {
        return new self($id);
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public function equals(Id $other): bool
    {
        return $this->id == $other->id;
    }

    public function getValue(): string
    {
        return $this->id;
    }

    private function setId(string $id): void
    {
        $id = strtolower($id);
        $id = str_replace(' ', '_', $id);
        $id = preg_replace('/[^a-z0-9_]/', '', $id);
        $id = preg_replace('/_+/', '_', $id);
        $id = trim($id, '_');

        $this->id = $id;
    }

}