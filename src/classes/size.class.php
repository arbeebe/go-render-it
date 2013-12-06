<?php
/**
 * Created by IntelliJ IDEA.
 * User: joseph
 * Date: 06/12/13
 * Time: 18:52
 * To change this template use File | Settings | File Templates.
 */

require_once __DIR__ . '../../constants/size.constants.php';
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