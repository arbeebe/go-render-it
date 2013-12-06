<?php

require_once __DIR__ . '/../src/classes/colour.class.php';

class ColourTest extends PHPUnit_Framework_TestCase
{

    public function testColourDefaultConstructor()
    {
        $colour = new Colour();
        assert($colour->getColour() == null);
        assert($colour != null);
    }

    public function testColourSetConstructor()
    {
        $colourString = "DDDAFA";
        $colour = new Colour($colourString);
        parent::assertEquals($colour->getColour() , $colourString);
    }

    public function testSetColour()
    {
        $colour = new Colour();
        $colourString = "DDDAFA";
        $colour->setColour($colourString);
        parent::assertEquals($colour->getColour() , $colourString);
    }

    public function testColourHexValidation()
    {
        $colour = new Colour();
        $colourString = "DDDAFA";
        $colour->setColour($colourString);
        parent::assertTrue($colour->isValid());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Colour a09kl0-wqe081230123 is not a valid value
     */
    public function testColourHexConvertThrowsException()
    {
        $colour = new Colour();
        $colourString = "a09kl0-wqe081230123";
        $colour->setColour($colourString);
        $colour->convertToHexString();
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Colour a09kl0-wqe081230123 is not a valid value
     */
    public function testColourRGBConvert()
    {
        $colour = new Colour();
        $colourString = "a09kl0-wqe081230123";
        $colour->setColour($colourString);
        $colour->convertToRGB();
    }
    public function testHexColourWhenConverted()
    {
        $colour = new Colour();
        $colourString = "DDDAFA";
        $colour->setColour($colourString);
        parent::assertEquals($colour->convertToHexString() , $colourString);
    }

    public function testConvertFromRGBToHEx()
    {
        $colour = new Colour();
        $colourString = "123,223,100";
        $colour->setColour($colourString);
        parent::assertEquals("7bdf64" , $colour->convertToHexString());
        parent::assertEquals("7bdf64" , $colour->getColour());
    }

    public function testConvertHexToRGB()
    {
        $colour = new Colour();
        $colourString = "ff9900";
        $colour->setColour($colourString);
        parent::assertEquals("255,153,000" , $colour->convertToRGB());
    }

    public function testAll(){
        $colour = new Colour();
        $colourString = "ff9900";
        $colour->setColour($colourString);
        parent::assertEquals("255,153,000" , $colour->convertToRGB());
        $colour->convertToHexString();
        parent::assertEquals($colour->getColour() , $colourString);
    }

    public function testIsValidRequestHEX(){
        $colour = new Colour();
        $request = "FFDAFF";
        parent::assertTrue(Colour::isValidRequest($request,$colour));
        parent::assertEquals($request,$colour->getColour());
    }

    public function testIsValidRequestRGB(){
        $colour = new Colour();
        $request = "123,222,110";
        parent::assertTrue(Colour::isValidRequest($request,$colour));
        parent::assertEquals($request,$colour->getColour());
    }
}
