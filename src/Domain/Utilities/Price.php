<?php
namespace App\Domain\Utilities;

use Ramsey\Uuid\UuidInterface as RamseyUuidInterface;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Price {

    private int $price;

    private function __construct(int $price)
    {
        $this->setPrice($price);
    }

    public static function fromInt(int $price): self
    {
        return new self($price);
    }
    public static function fromString(string $price): self
    {
        return new self((int) $price);
    }

    public function equals(Price $other): bool
    {
        return $this->price === $other->price;
    }

    public function getValue(): int
    {
        return $this->price;
    }

    private function setPrice(int $price): void
    {
        if ($price < 0) {
            throw new PriceInvalidException("Price cannot be less than zero");
        }
        $this->price = $price;
    }
}