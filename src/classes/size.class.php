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

require_once dirname(__FILE__) . '../../constants/size.constants.php';
class Size
{

    private $height = DEFAULT_HEIGHT;
    private $width = DEFAULT_WIDTH;

    function __construct($height = false, $width = false)
    {
        if ($width)
            $this->setWidth($width);
        if ($height)
            $this->setHeight($height);
    }

    public static function isValidRequest($value, Size &$newObject)
    {
        if (preg_match(REGEX_SIZE_STRING, $value) || preg_match(REGEX_SIZE, $value)) {
            if (!is_null($newObject)) {
                if (preg_match(REGEX_SIZE_STRING, $value)) {
                    $value = explode(JOINER, strtolower($value));
                    $newObject = new Size($value[1], $value[0]);
                } else {
                    $newObject = new Size($value, $value);
                }
            }
            return true;

        }

        return false;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height)
    {
        if (is_numeric($height))
            $this->height = $height;
        else
            throw new InvalidArgumentException();
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        if (is_numeric($width))
            $this->width = $width;
        else
            throw new InvalidArgumentException();
    }


}