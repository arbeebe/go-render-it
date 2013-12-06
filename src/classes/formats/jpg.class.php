<?php

require_once __DIR__ . "/format.class.php";


class JPG extends AbstractFormat{

    function getFormatHeader()
    {
        return "Content-type: image/jpg";
    }

    function create(&$image)
    {
       imagejpeg($image);
    }
}
?>