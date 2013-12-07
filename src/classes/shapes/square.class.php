<?php

require_once __DIR__ . "/abstract.shape.class.php";

class Square extends AbstractShape{

    public function createShape(ImageRenderer &$imageRenderObject)
    {
        $colour = $imageRenderObject->getColour();
        $colour->convertToRGB();
                $coloursRGB = explode(',',$colour->getColour());
        imagecolorallocate($imageRenderObject->getResource(), $coloursRGB[0], $coloursRGB[1], $coloursRGB[2]);
    }

}
?>