<?php
namespace App\Domain\Utilities;

use Ramsey\Uuid\UuidInterface as RamseyUuidInterface;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid {

    private RamseyUuidInterface $uuid;

    public function __construct(string $uuid)
    {
        if (!RamseyUuid::isValid($uuid)) {
            throw new IdInvalidException("Invalid UUID provided: $uuid");
        }

        $this->uuid = RamseyUuid::fromString($uuid);
    }

    public static function fromString(string $uuid): self
    {
        return new self($uuid);
    }

    public static function generate(): self
    {
        return new self(RamseyUuid::uuid4()->toString());
    }

    public static function generateToString(): string
    {
        return (new self(RamseyUuid::uuid4()->toString()))->__toString();
    }


    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    public function equals(Uuid $other): bool
    {
        return $this->uuid->equals($other->uuid);
    }

    public function getValue(): RamseyUuidInterface
    {
        return $this->uuid;
    }

}