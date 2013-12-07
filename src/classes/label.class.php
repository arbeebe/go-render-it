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

require_once __DIR__ . "/../constants/label.constants.php";
class Label
{

    private $labelText = "";

    function __construct($labelText = false)
    {
        if ($labelText)
            $this->labelText = $labelText;
    }


    public static function isValidRequest($value, Label &$labelObject)
    {
        if (preg_match_all(LABEL_REGEX, $value, $matches)) {
            $labelObject = new Label();
            $labelObject->setLabelText(str_replace(LABEL_ID, EMPTY_STRING, $value));
            return true;
        }

        return false;
    }

    public function createLabelTextFromSize(Size $size)
    {
        $this->setLabelText($size->getWidth() . "x" . $size->getHeight());
    }

    public function getLabelText()
    {
        return $this->labelText;
    }

    public function setLabelText($string)
    {
        $this->labelText = $string;
    }

    public function renderText(ImageRenderer &$imageObject)
    {
        $color = imagecolorallocate($imageObject->getResource(), 255, 255, 255);
        $grey = imagecolorallocate($imageObject->getResource(), 128, 128, 128);

        $font_size = 1;
        $txt_max_width = intval(0.5 * (ImageSX($imageObject->getResource()) + $imageObject->getBorder()->getThickness()));
        $txt_max_height = intval(0.5 * (ImageSY($imageObject->getResource()) + $imageObject->getBorder()->getThickness()));

        do {
            $font_size++;
            $p = imagettfbbox($font_size, 0, FONT_PATH, $this->getLabelText());
            $txt_width = $p[2] - $p[0];
            $txt_height = $p[1] - $p[7];

        } while (($txt_width <= $txt_max_width) && ($txt_height <= $txt_max_height));

        $ascent = abs($p[7]);
        $descent = abs($p[1]);
        $height = $ascent + $descent;

        $y = (((ImageSX($imageObject->getResource()) + $imageObject->getBorder()->getThickness()) / 2) - ($height / 2)) + $ascent;
        $x = ((ImageSX($imageObject->getResource()) + $imageObject->getBorder()->getThickness()) - $txt_width) / 2;
        imagettftext($imageObject->getResource(), $font_size, 0, $x, $y + 3, $grey, FONT_PATH, $this->getLabelText());
        imagettftext($imageObject->getResource(), $font_size, 0, $x, $y, $color, FONT_PATH, $this->getLabelText());
    }
}

?>