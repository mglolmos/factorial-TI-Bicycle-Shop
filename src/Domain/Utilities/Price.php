<?php
namespace App\Domain\Utilities;

use Ramsey\Uuid\UuidInterface as RamseyUuidInterface;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Price {

    private int $price;

    public function __construct(string $price)
    {
        if ($price < 0) {
            throw new PriceInvalidException("Price cannot be less than zero");
        }
        $this->price = $price;
    }

    public function equals(Price $other): bool
    {
        return $this->price === $other->price;
    }

    public function getValue(): int
    {
        return $this->price;
    }
}