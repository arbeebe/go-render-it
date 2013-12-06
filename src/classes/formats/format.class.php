<?php

require_once __DIR__ ."/format.interface.php";
require_once __DIR__ ."/format.regex.php";

abstract class  AbstractFormat implements Format
{

    public static function resolveFormat($value, Format &$formatObject)
    {
        if (preg_match(JPG, $value)) {
            $formatObject = new JPG();
            return true;
        }


        if (preg_match(PNG, $value)) {
            $formatObject = new PNG();
            return true;
        }


        if (preg_match(GIF, $value)) {
            $formatObject = new GIF();
            return true;
        }

        return false;
    }
}

?>