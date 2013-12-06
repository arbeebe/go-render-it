<?php
/**
 * Created by IntelliJ IDEA.
 * User: joseph
 * Date: 06/12/13
 * Time: 18:53
 * To change this template use File | Settings | File Templates.
 */


require_once __DIR__ . '/../src/classes/size.class.php';

class SizeTest extends PHPUnit_Framework_TestCase {

    public function testNullConstructor(){
        $size = new Size();
        $this->assertEquals(300,$size->getHeight());
        $this->assertEquals(300,$size->getWidth());
    }

    public function testSetConstructor(){
        $size = new Size(150,250);
        $this->assertEquals(250,$size->getWidth());
        $this->assertEquals(150,$size->getHeight());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetConstructorWrongBoth(){
        $size = new Size("dsa","asd");
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorOneWrongHeight(){
        $size = new Size("asd",123);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetConstructorWrongWidth(){
        $size = new Size(300,"asd");
    }

    public function testHeightSetter(){
        $size = new Size();
        $size->setHeight(500);
        $this->assertEquals(500,$size->getHeight());
    }

    public function testWidthSetter(){
        $size = new Size();
        $size->setWidth(500);
        $this->assertEquals(500,$size->getWidth());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testHeightSetterException(){
        $size = new Size();
        $size->setHeight("500");
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testWidthSetterException(){
        $size = new Size();
        $size->setWidth("Some random string");
    }
}
