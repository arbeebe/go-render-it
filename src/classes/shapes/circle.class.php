<?php
require_once __DIR__ . "/abstract.shape.class.php";

class Circle extends  AbstractShape{

    public function createShape(ImageRenderer &$imageRenderObject)
    {
        $colour = $imageRenderObject->getColour();
        $colour->convertToRGB();
        $coloursRGB = explode(',',$colour->getColour());
        $white = imagecolorallocate($imageRenderObject->getResource(), 255, 255, 255);
        $colourCreated = imagecolorallocate($imageRenderObject->getResource(), $coloursRGB[0], $coloursRGB[1], $coloursRGB[2]);
        imagecolortransparent($imageRenderObject->getResource(),$white);
        imagefilledellipse($imageRenderObject->getResource(),$imageRenderObject->getSize()->getWidth() / 2,
            $imageRenderObject->getSize()->getHeight() / 2,$imageRenderObject->getSize()->getWidth()-5,
            $imageRenderObject->getSize()->getHeight()-5,$colourCreated);
    }
}
?>