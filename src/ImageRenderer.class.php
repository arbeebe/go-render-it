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

/**
 * Class ImageRenderer will render an image from passed
 * parameters and write it to the response.
 */
class ImageRenderer
{
    private $size;
    private $textString;
    private $image = null;
    private $borderWidth = DEFAULT_BORDER;
    private $colour;
    private $showBorder = SHOW_BORDER;
    private $showLabel = SHOW_LABEL;

    /**
     * Default constructor generates a default label to be placed on
     * the image.
     */
    function __construct()
    {
        $this->textString = DEFAULT_HEIGHT . SIZE_JOINER . DEFAULT_WIDTH;
        $this->colour = new Colour(DEFAULT_FILL);
        $this->size = new Size();
    }

    /**
     *  With all the information provided or only using the defaults,
     *  this method will perform the render of the image.
     */
    public function render()
    {

        $this->colour->convertToRGB();
        $coloursRGB = explode(',',$this->colour->getColour());

        $this->image = imagecreate($this->size->getWidth(),$this->size->getHeight());
        imagecolorallocate($this->image, $coloursRGB[0], $coloursRGB[1], $coloursRGB[2]);

        if ($this->showLabel) {
            $this->renderText();
        }
        header(CONTENT_TYPE);


        if ($this->showBorder) {
            $black = imagecolorallocate($this->image, 0, 0, 0);
            imagesetthickness($this->image, $this->borderWidth);
            imagerectangle($this->image, 0, 0, ImageSX($this->image), ImageSY($this->image), $black);
        }

        imagepng($this->image);
        imagedestroy($this->image);
    }

    /**
     * Method to render the text (label) to be placed onto the image.
     */
    private function renderText()
    {
        $color = imagecolorallocate($this->image, 255, 255, 255);
        $grey = imagecolorallocate($this->image, 128, 128, 128);

        $font_size = 1;
        $txt_max_width = intval(0.5 * $this->size->getWidth());
        $txt_max_height = intval(0.5 * $this->size->getHeight());

        do {
            $font_size++;
            $p = imagettfbbox($font_size, 0, FONT_PATH, $this->textString);
            $txt_width = $p[2] - $p[0];
            $txt_height = $p[1] - $p[7];

        } while (($txt_width <= $txt_max_width) && ($txt_height <= $txt_max_height));

        $ascent = abs($p[7]);
        $descent = abs($p[1]);
        $height = $ascent + $descent;

        $y = (($this->size->getHeight() / 2) - ($height / 2)) + $ascent;
        $x = ($this->size->getWidth() - $txt_width) / 2;
        imagettftext($this->image, $font_size, 0, $x, $y + 3, $grey, FONT_PATH, $this->textString);
        imagettftext($this->image, $font_size, 0, $x, $y, $color, FONT_PATH, $this->textString);
    }

    /**
     * The image height and width have all ready been set to the Defaults defined in
     * ImageRenderer.constants.php, the passed values will overwrite them if valid numbers.
     *
     * @param $height desired height of the image.
     * @param $width  desired width of the image.
     */
    public function setDimensions(Size $size)
    {
       $this->size = $size;
       $this->setTextString($this->size->getWidth() . SIZE_JOINER . $this->size->getHeight());
    }

    /**
     * Method to set the colour of the image background fill, use a hex colour
     * representation for example "FFFAEA"
     *
     * If the setting of the colour fails then the colour defined in ImageRender.constants.php
     * will be used.
     *
     * @param $colour "FFFAEA2"
     */
    public function setColour(Colour $colour)
    {
        if($colour->isValid()){
            $this->colour = $colour;
        }
    }

    /**
     * Method to allow the setting of the border data on the image.
     *
     * @param $border boolean to show borders around image.
     * @param $borderWidth desired image border width.
     */
    public function setBorder($border, $borderWidth)
    {
        $this->borderWidth = $borderWidth;
        $this->showBorder = $border;
    }

    /**
     * Method to set the visibility of the label on the image.
     *
     * @param boolean $showLabel
     */
    public function setShowLabel($showLabel)
    {
        $this->showLabel = $showLabel;
    }

    /**
     * Method to set the value of the label, if this method is not
     * called then the default label is used which is "height x width"
     *
     * @param mixed $textString
     */
    public function setTextString($textString)
    {
        $this->textString = $textString;
    }

}

?>