<?php

require_once __DIR__ . "/format.class.php";


class GIF extends  AbstractFormat{

    function getFormatHeader()
    {
        return "Content-type: image/gif";
    }

    function create(&$image)
    {
        imagegif($image);
    }
}
?>