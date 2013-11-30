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

/**
 * Class ImageRenderer will render an image from passed
 * parameters and write it to the response.
 */
class ImageRenderer
{
    private $textString;
    private $image = null;
    private $height = DEFAULT_HEIGHT;
    private $width = DEFAULT_WIDTH;
    private $borderWidth = DEFAULT_BORDER;
    private $colour = DEFAULT_FILL;
    private $showBorder = SHOW_BORDER;
    private $showLabel = SHOW_LABEL;

    /**
     * Default constructor generates a default label to be placed on
     * the image.
     */
    function __construct()
    {
        $this->textString = DEFAULT_HEIGHT . SIZE_JOINER . DEFAULT_WIDTH;
    }

    /**
     *  With all the information provided or only using the defaults,
     *  this method will perform the render of the image.
     */
    public function render()
    {
        if (is_array($this->colour)) {
            $coloursRGB = $this->colour;
        } else {
            $coloursRGB = $this->hexStringToRGB($this->colour);
        }

        $this->image = imagecreate($this->width, $this->height);
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
     * Method converts a hex colour representation string to an rgb array.
     *
     * @param $hexString "FFAEDEF"
     * @return array array(123,100,50)
     */
    private function hexStringToRGB($hexString)
    {
        if (strlen($hexString) == 3) {
            $red = hexdec(substr($hexString, 0, 1) . substr($hexString, 0, 1));
            $green = hexdec(substr($hexString, 1, 1) . substr($hexString, 1, 1));
            $blue = hexdec(substr($hexString, 2, 1) . substr($hexString, 2, 1));
        } else {
            $red = hexdec(substr($hexString, 0, 2));
            $green = hexdec(substr($hexString, 2, 2));
            $blue = hexdec(substr($hexString, 4, 2));
        }
        $rgb = array($red, $green, $blue);
        return $rgb;
    }

    /**
     * Method to render the text (label) to be placed onto the image.
     */
    private function renderText()
    {
        $color = imagecolorallocate($this->image, 255, 255, 255);
        $grey = imagecolorallocate($this->image, 128, 128, 128);

        $font_size = 1;
        $txt_max_width = intval(0.5 * $this->width);
        $txt_max_height = intval(0.5 * $this->height);

        do {
            $font_size++;
            $p = imagettfbbox($font_size, 0, FONT_PATH, $this->textString);
            $txt_width = $p[2] - $p[0];
            $txt_height = $p[1] - $p[7];

        } while (($txt_width <= $txt_max_width) && ($txt_height <= $txt_max_height));

        $ascent = abs($p[7]);
        $descent = abs($p[1]);
        $height = $ascent + $descent;

        $y = (($this->height / 2) - ($height / 2)) + $ascent;
        $x = ($this->width - $txt_width) / 2;
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
    public function setDimensions($height, $width)
    {
        if (!empty($height) && is_numeric($height)) {
            if (!empty($width) && is_numeric($width)) {
                $this->width = $width;
                $this->height = $height;
                $this->textString = $width . SIZE_JOINER . $height;
            }
        }


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
    public function setColour($colour)
    {
        if (!empty($colour)) {
            if (strlen($colour) == HEX_LENGTH) {
                $this->colour = $colour;
            } else {
                if (strpos($colour, DELIMITER)) {
                    $coloursRGB = explode(DELIMITER, $colour);
                    if (count($coloursRGB) != RGB_COUNT) {
                        $this->colour = DEFAULT_FILL;
                    } else {
                        $this->colour = $coloursRGB;
                    }
                } else {
                    $this->colour = DEFAULT_FILL;
                }
            }
        } else {
            $this->colour = DEFAULT_FILL;
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