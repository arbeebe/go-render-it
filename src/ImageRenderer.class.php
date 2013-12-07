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

/**
 * Class ImageRenderer will render an image from passed
 * parameters and write it to the response.
 */
class ImageRenderer
{
    private $size;
    private $image = null;
    private $borderWidth = DEFAULT_BORDER;
    private $colour;
    private $showBorder = SHOW_BORDER;
    private $label;
    private $format;

    function __construct()
    {
        $this->label = new Label(DEFAULT_WIDTH .SIZE_JOINER .DEFAULT_HEIGHT );
        $this->colour = new Colour(DEFAULT_FILL);
        $this->size = new Size();
        $this->format = new PNG();
    }

    public function render()
    {

        $this->colour->convertToRGB();
        $coloursRGB = explode(',',$this->colour->getColour());

        $this->image = imagecreate($this->size->getWidth(),$this->size->getHeight());
        imagecolorallocate($this->image, $coloursRGB[0], $coloursRGB[1], $coloursRGB[2]);

        $this->label->renderText($this);
        header($this->format->getFormatHeader());


        if ($this->showBorder) {
            $black = imagecolorallocate($this->image, 0, 0, 0);
            imagesetthickness($this->image, $this->borderWidth);
            imagerectangle($this->image, 0, 0, ImageSX($this->image), ImageSY($this->image), $black);
        }

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
        if($colour->isValid()){
            $this->colour = $colour;
        }
    }

    public function setBorder($border, $borderWidth)
    {
        $this->borderWidth = $borderWidth;
        $this->showBorder = $border;
    }

    public function getSize(){
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

}

?>