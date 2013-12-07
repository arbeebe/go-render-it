<?php

/**
The MIT License (MIT)

Copyright (c) 2013 Joseph McCarthy

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
the Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

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
        parent::assertEquals($colour->getColour(), $colourString);
    }

    public function testSetColour()
    {
        $colour = new Colour();
        $colourString = "DDDAFA";
        $colour->setColour($colourString);
        parent::assertEquals($colour->getColour(), $colourString);
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
        parent::assertEquals($colour->convertToHexString(), $colourString);
    }

    public function testConvertFromRGBToHEx()
    {
        $colour = new Colour();
        $colourString = "123,223,100";
        $colour->setColour($colourString);
        parent::assertEquals("7bdf64", $colour->convertToHexString());
        parent::assertEquals("7bdf64", $colour->getColour());
    }

    public function testConvertHexToRGB()
    {
        $colour = new Colour();
        $colourString = "ff9900";
        $colour->setColour($colourString);
        parent::assertEquals("255,153,000", $colour->convertToRGB());
    }

    public function testAll()
    {
        $colour = new Colour();
        $colourString = "ff9900";
        $colour->setColour($colourString);
        parent::assertEquals("255,153,000", $colour->convertToRGB());
        $colour->convertToHexString();
        parent::assertEquals($colour->getColour(), $colourString);
    }

    public function testIsValidRequestHEX()
    {
        $colour = new Colour();
        $request = "FFDAFF";
        parent::assertTrue(Colour::isValidRequest($request, $colour));
        parent::assertEquals($request, $colour->getColour());
    }

    public function testIsValidRequestRGB()
    {
        $colour = new Colour();
        $request = "123,222,110";
        parent::assertTrue(Colour::isValidRequest($request, $colour));
        parent::assertEquals($request, $colour->getColour());
    }

    public function testConvertFromRGBToHExBlack()
    {
        $colour = new Colour();
        $colourString = "0,0,0";
        $colour->setColour($colourString);
        parent::assertEquals("000000", $colour->convertToHexString());
        parent::assertEquals("000000", $colour->getColour());
    }
}
