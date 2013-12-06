<?php

interface Format{
    function getFormatHeader();

    function create(&$image);
}
?>