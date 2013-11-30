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
require_once "constants/ImageRequestRegex.constants.php";
require_once "ImageRenderer.class.php";

class ImageRequestHandler
{

    private $colour;
    private $imageObject;
    private $height;
    private $width;
    private $label;
    private $request;

    function __construct($requestString = false)
    {
        $this->request = explode(URL_DELIMITER, $requestString);
    }

    public function setRequestString($requestString)
    {
        $this->request = explode(URL_DELIMITER, $requestString);
    }

    public function render()
    {
        $this->processRequest();

        $this->imageObject = new ImageRenderer();
        $this->imageObject->setDimensions($this->height, $this->width);
        $this->imageObject->setColour($this->colour);

        if (!empty($this->label)) {
            $this->imageObject->setTextString($this->label);
        }

        $this->imageObject->render();
    }

    private function processRequest()
    {
        foreach ($this->request as $value) {

            if (preg_match_all(REGEX_HEX, $value, $matches) || preg_match_all(REGEX_RGB, $value, $matches)) {
                $this->colour = $value;
                continue;
            }

            if (preg_match_all(REGEX_SIZE_STRING, $value, $matches) || preg_match_all(REGEX_SIZE, $value, $matches)) {
                if (preg_match_all(REGEX_SIZE_STRING, $value, $matches)) {
                    $value = explode(SIZE_JOINER, strtolower($value));
                    $this->width = $value[0];
                    $this->height = $value[1];
                } else {
                    $this->height = $value;
                    $this->width = $value;
                }

                continue;
            }

            if (preg_match_all(LABEL_REGEX, $value, $matches)) {
                $this->label = str_replace(LABEL_ID, EMPTY_STRING, $value);
                continue;
            }
        }
    }
}