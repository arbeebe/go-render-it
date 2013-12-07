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


require_once __DIR__ . '/../src/classes/size.class.php';

class SizeTest extends PHPUnit_Framework_TestCase
{

    public function testNullConstructor()
    {
        $size = new Size();
        parent::assertEquals(300, $size->getHeight());
        parent::assertEquals(300, $size->getWidth());
    }

    public function testSetConstructor()
    {
        $size = new Size(150, 250);
        parent::assertEquals(250, $size->getWidth());
        parent::assertEquals(150, $size->getHeight());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetConstructorWrongBoth()
    {
        $size = new Size("dsa", "asd");
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorOneWrongHeight()
    {
        $size = new Size("asd", 123);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetConstructorWrongWidth()
    {
        $size = new Size(300, "asd");
    }

    public function testHeightSetter()
    {
        $size = new Size();
        $size->setHeight(500);
        parent::assertEquals(500, $size->getHeight());
    }

    public function testWidthSetter()
    {
        $size = new Size();
        $size->setWidth(500);
        parent::assertEquals(500, $size->getWidth());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testHeightSetterException()
    {
        $size = new Size();
        $size->setHeight("hjk500");
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testWidthSetterException()
    {
        $size = new Size();
        $size->setWidth("Some random string");
    }

    public function testCreateObjectWithValidStringRequest()
    {
        $sizeObject = new Size();
        $request = "1000x500";
        parent::assertTrue(Size::isValidRequest($request, $sizeObject));
        parent::assertEquals(1000, $sizeObject->getWidth());
        parent::assertEquals(500, $sizeObject->getHeight());
    }

    public function testCreateObjectWithValidNumberRequest()
    {
        $sizeObject = new Size();
        $request = 700;
        parent::assertTrue(Size::isValidRequest($request, $sizeObject));
        parent::assertEquals(700, $sizeObject->getWidth());
        parent::assertEquals(700, $sizeObject->getHeight());
    }

    public function testFailedCreateObjectWithValidStringRequest()
    {
        $sizeObject = new Size();
        $request = "1000jhgfx500";
        parent::assertFalse(Size::isValidRequest($request, $sizeObject));
        parent::assertEquals(300, $sizeObject->getWidth());
        parent::assertEquals(300, $sizeObject->getHeight());
    }

    public function testFailedCreateObjectWithValidNumberRequest()
    {
        $sizeObject = new Size();
        $request = "700asdasd";
        parent::assertFalse(Size::isValidRequest($request, $sizeObject));
        parent::assertEquals(300, $sizeObject->getWidth());
        parent::assertEquals(300, $sizeObject->getHeight());
    }
}
