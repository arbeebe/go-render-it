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

require_once __DIR__ . "/abstract.shape.class.php";

class Circle extends AbstractShape
{

    public function createShape(ImageRenderer &$imageRenderObject)
    {
        $colour = $imageRenderObject->getColour();
        $colour->convertToRGB();
        $coloursRGB = explode(',', $colour->getColour());
        $white = imagecolorallocate($imageRenderObject->getResource(), 255, 255, 255);
        $colourCreated = imagecolorallocate($imageRenderObject->getResource(), $coloursRGB[0], $coloursRGB[1], $coloursRGB[2]);
        imagecolortransparent($imageRenderObject->getResource(), $white);
        imagefilledellipse($imageRenderObject->getResource(), $imageRenderObject->getSize()->getWidth() / 2,
            $imageRenderObject->getSize()->getHeight() / 2, $imageRenderObject->getSize()->getWidth() - 5,
            $imageRenderObject->getSize()->getHeight() - 5, $colourCreated);
    }
}

?>