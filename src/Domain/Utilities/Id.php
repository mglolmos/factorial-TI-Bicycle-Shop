<?php
namespace App\Domain\Utilities;

use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Uuid;

class Id {

    private UuidInterface $uuid;

    public function __construct(string $uuid)
    {
        if (!Uuid::isValid($uuid)) {
            throw new IdInvalidException("Invalid UUID provided: $uuid");
        }

        $this->uuid = Uuid::fromString($uuid);
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    public function equals(Id $other): bool
    {
        return $this->uuid->equals($other->uuid);
    }

    public function getValue(): UuidInterface
    {
        return $this->uuid;
    }

}