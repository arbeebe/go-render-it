<?php
/**
 * Created by IntelliJ IDEA.
 * User: joseph
 * Date: 06/12/13
 * Time: 18:52
 * To change this template use File | Settings | File Templates.
 */

class Size
{

    private $height = 300;
    private $width = 300;

    function __construct($height = false, $width = false)
    {
        if($width)
        $this->setWidth($width);
        if($height)
        $this->setHeight($height);
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height)
    {
        if (is_int($height))
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
        if (is_int($width))
            $this->width = $width;
        else
            throw new InvalidArgumentException();
    }


}