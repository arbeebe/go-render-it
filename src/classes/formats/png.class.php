<?php
require_once __DIR__ . "/format.class.php";

class PNG extends  AbstractFormat{

    function getFormatHeader()
    {
       return "Content-type: image/png";
    }

    function create(&$image)
    {
       imagepng($image);
    }
}
?>