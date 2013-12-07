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

require_once "constants/ImageRenderer.constants.php";
require_once "classes/colour.class.php";
require_once "classes/formats/png.class.php";
require_once "classes/formats/jpg.class.php";
require_once "classes/formats/gif.class.php";
require_once "classes/shapes/square.class.php";
require_once "classes/shapes/circle.class.php";
require_once "classes/border.class.php";

/**
 * Class ImageRenderer will render an image from passed
 * parameters and write it to the response.
 */
class ImageRenderer
{
    private $size;
    private $image = null;
    private $colour;
    private $label;
    private $format;
    private $shape;
    private $borderObject;

    function __construct()
    {
        $this->label = new Label(DEFAULT_WIDTH . SIZE_JOINER . DEFAULT_HEIGHT);
        $this->colour = new Colour(DEFAULT_FILL);
        $this->size = new Size();
        $this->format = new PNG();
        $this->shape = new Square();
        $this->borderObject = new Border();
    }

    public function render()
    {

        if($this->borderObject->isVisible()){
            $this->image = imagecreate($this->size->getWidth()+$this->borderObject->getThickness(),
                $this->size->getHeight()+$this->borderObject->getThickness());
        } else {
            $this->image = imagecreate($this->size->getWidth(), $this->size->getHeight());
        }


        $this->shape->createShape($this);
        $this->label->renderText($this);
        header($this->format->getFormatHeader());

        $this->format->create($this->image);

        imagedestroy($this->image);
    }

    public function getResource()
    {
        return $this->image;
    }

    public function setDimensions(Size $size)
    {
        $this->size = $size;
    }

    public function setColour(Colour $colour)
    {
        if ($colour->isValid()) {
            $this->colour = $colour;
        }
    }

    public function setBorder(Border $borderObject)
    {
       $this->borderObject = $borderObject;
    }

    public function getBorder(){
        return $this->borderObject;
    }

    public function getSize()
    {
        return $this->size;
    }


    public function setText(Label $labelObject)
    {
        $this->label = $labelObject;
    }

    public function setFormat($format)
    {
        $this->format = $format;
    }

    public function getColour()
    {
        return $this->colour;
    }

    public function setShape(AbstractShape $shape)
    {
        $this->shape = $shape;
    }

}

?>