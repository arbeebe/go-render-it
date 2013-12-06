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
require_once "ImageRenderer.class.php";
require_once "classes/colour.class.php";
require_once "classes/size.class.php";
require_once "constants/ImageRequestRegex.constants.php";
require_once "classes/formats/format.class.php";

class ImageRequestHandler
{

    private $colour;
    private $imageObject;
    private $label;
    private $request;
    private $size;
    private $format;

    function __construct($requestString = false)
    {
        $this->colour = new Colour();
        $this->size = new Size();
        $this->format = new PNG();
        $this->setRequestString($requestString);
    }

    public function setRequestString($requestString)
    {
        $this->request = explode(URL_DELIMITER, $requestString);
    }

    public function render()
    {
        $this->processRequest();
        $this->imageObject = new ImageRenderer();
        $this->imageObject->setDimensions($this->size);
        $this->imageObject->setColour($this->colour);
        $this->imageObject->setFormat($this->format);

        if (!empty($this->label)) {
            $this->imageObject->setTextString($this->label);
        }

        $this->imageObject->render();
    }

    private function processRequest()
    {
        foreach ($this->request as $value) {

            Colour::isValidRequest($value,$this->colour);
            Size::isValidRequest($value,$this->size);
            AbstractFormat::resolveFormat($value,$this->format);

            if (preg_match_all(LABEL_REGEX, $value, $matches)) {
                $this->label = str_replace(LABEL_ID, EMPTY_STRING, $value);
                continue;
            }
        }
    }
}