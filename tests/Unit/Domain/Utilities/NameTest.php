<?php
namespace App\Tests\Unit\Domain\Utilities;


use App\Domain\Utilities\NameInvalidException;
use PHPUnit\Framework\TestCase;
use App\Domain\Utilities\Name;

class NameTest extends TestCase {

    public function testNameWithAProperName()
    {
        $correct_name = "This is a correct name";
        $name_value_object = new Name($correct_name);
        $this->assertEquals($correct_name, $name_value_object->getNameValue());
    }

    public function testNameWithEmptyNameShouldThrowException()
    {
        $this->expectException(NameInvalidException::class);
        new Name("");
    }

    public function testNameWithJustSpacesShouldThrowException()
    {
        $this->expectException(NameInvalidException::class);
        new Name("   ");
    }

    public function testNameMustBeTrimmed()
    {
        $name = "  name without trimmed  ";
        $output_name = new Name($name);
        $this->assertEquals("name without trimmed", $output_name->getNameValue());
    }

    public function testNameMustHaveAtLeast3Characters()
    {
        $this->expectException(NameInvalidException::class);
        new Name("a");
    }

    public function testNameMustHaveMax100Characters()
    {
        $this->expectException(NameInvalidException::class);
        new Name("When user input exceeds the maximum allowed length of 100 characters, an exception should be thrown to ensure data integrity");
    }
}