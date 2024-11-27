<?php
namespace App\Tests\Unit\Domain\Utilities;


use App\Domain\Utilities\Uuid;
use App\Domain\Utilities\IdInvalidException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as RamseyUuid;

class UuidTest extends TestCase {

    public function testValidUuidCreation()
    {
        $uuidString = RamseyUuid::uuid4()->toString();
        $uuid = new Uuid($uuidString);

        $this->assertEquals($uuidString, (string)$uuid);
    }

    public function testInvalidUuidThrowsException()
    {
        $this->expectException(IdInvalidException::class);
        $this->expectExceptionMessage("Invalid UUID provided: invalid-uuid");

        new Uuid("invalid-uuid");
    }

    public function testGenerateCreatesValidUuid()
    {
        $uuid = Uuid::generate();

        $this->assertInstanceOf(Uuid::class, $uuid);
        $this->assertTrue(RamseyUuid::isValid((string)$uuid));
    }

    public function testGenerateToStringReturnsValidUuidString()
    {
        $uuidString = Uuid::generateToString();

        $this->assertTrue(RamseyUuid::isValid($uuidString));
        $this->assertNotEmpty($uuidString);
    }

    public function testEqualsMethod()
    {
        $uuid1 = new Uuid(RamseyUuid::uuid4()->toString());
        $uuid2 = new Uuid((string)$uuid1);

        $this->assertTrue($uuid1->equals($uuid2));

        $uuid3 = Uuid::generate();
        $this->assertFalse($uuid1->equals($uuid3));
    }

}