<?php
namespace App\Tests\Unit\Domain\Utilities;


use App\Domain\Utilities\Id;
use App\Domain\Utilities\IdInvalidException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class IdTest extends TestCase {

    public function testValidUuidCreation()
    {
        $uuidString = Uuid::uuid4()->toString();
        $uuid = new Id($uuidString);

        $this->assertEquals($uuidString, (string)$uuid);
    }

    public function testInvalidUuidThrowsException()
    {
        $this->expectException(IdInvalidException::class);
        $this->expectExceptionMessage("Invalid UUID provided: invalid-uuid");

        new Id("invalid-uuid");
    }

    public function testGenerateCreatesValidUuid()
    {
        $uuid = Id::generate();

        $this->assertInstanceOf(Id::class, $uuid);
        $this->assertTrue(Uuid::isValid((string)$uuid));
    }

    public function testGenerateToStringReturnsValidUuidString()
    {
        $uuidString = Id::generateToString();

        $this->assertTrue(Uuid::isValid($uuidString));
        $this->assertNotEmpty($uuidString);
    }

    public function testEqualsMethod()
    {
        $uuid1 = new Id(Uuid::uuid4()->toString());
        $uuid2 = new Id((string)$uuid1);

        $this->assertTrue($uuid1->equals($uuid2));

        $uuid3 = Id::generate();
        $this->assertFalse($uuid1->equals($uuid3));
    }

}