<?php
namespace App\Tests\Unit\Domain\Utilities;

use App\Domain\Utilities\Id;
use PHPUnit\Framework\TestCase;

class IdTest extends TestCase {

    public function testValidIdCreation()
    {
        $id = new Id('this is a string');

        $this->assertEquals('this_is_a_string', $id->getValue());
    }

    public function testGenerateCreatesValidUuid()
    {
        $id = Id::generate('this is a string');
        $this->assertEquals('this_is_a_string', $id->getValue());
    }


    public function testEqualsMethod()
    {
        $id1 = new Id('this is a string');
        $id2 = new Id((string)$id1);

        $this->assertTrue($id1->equals($id2));

        $id3 = Id::generate('this is another string');
        $this->assertFalse($id1->equals($id3));
    }

    public function testSimpleString()
    {
        $input = "Hello World";
        $expected = "hello_world";
        $this->assertEquals($expected, (new Id($input))->getValue());
    }

    public function testStringWithSpecialCharacters()
    {
        $input = "PHP is Awesome!";
        $expected = "php_is_awesome";
        $this->assertEquals($expected, (new Id($input))->getValue());
    }

    public function testStringWithNumbers()
    {
        $input = "2024 - New Year!";
        $expected = "2024_new_year";
        $this->assertEquals($expected, (new Id($input))->getValue());
    }

    public function testStringWithExtraSpaces()
    {
        $input = "   Special   @ Characters # Test   ";
        $expected = "special_characters_test";
        $this->assertEquals($expected, (new Id($input))->getValue());
    }

    public function testStringWithOnlySpecialCharacters()
    {
        $input = "!@#$%^&*()";
        $expected = "";
        $this->assertEquals($expected, (new Id($input))->getValue());
    }

    public function testEmptyString()
    {
        $input = "";
        $expected = "";
        $this->assertEquals($expected, (new Id($input))->getValue());
    }

    public function testStringWithMultipleSpaces()
    {
        $input = "   Hello    World   ";
        $expected = "hello_world";
        $this->assertEquals($expected, (new Id($input))->getValue());
    }

    public function testStringWithUnderscores()
    {
        $input = "Hello__World";
        $expected = "hello_world";
        $this->assertEquals($expected, (new Id($input))->getValue());
    }






}