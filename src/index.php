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


require_once "constants.php";

// Code Start

$height = $_GET['x'];
$width = $_GET['y'];
$border = (bool)$_GET['border'];
$borderWidth = $_GET['thick'];
$colour = $_GET['background'];

$coloursRGB = null;

if (!empty($colour)) {
    if (strlen($colour) == HEX_LENGTH) {
        $coloursRGB = hexStringToRGB($colour);
    } else {
        if (strpos($colour, DELIMITER)) {
            $coloursRGB = explode(DELIMITER, $colour);
            if (count($coloursRGB) != RGB_COUNT) {
                $coloursRGB = defaultRGB();
            }
        } else {
            $coloursRGB = defaultRGB();
        }
    }
} else {
    $coloursRGB = defaultRGB();
}

if (empty($height) || !is_numeric($height)) {
    $height = DEFAULT_HEIGHT;
}

if (empty($width) || !is_numeric($width)) {
    $width = DEFAULT_WIDTH;
}

$borderWidth = checkBorderVar($borderWidth);
if (!is_bool($border)) {
    $border = false;
} else {
    if ($border) {
        if (empty($borderWidth) || !is_numeric($borderWidth)) {
            $borderWidth = checkBorderVar(DEFAULT_BORDER);
        }
    }
}

$image = imagecreate($width, $height);
$background = imagecolorallocate($image, $coloursRGB[0], $coloursRGB[1], $coloursRGB[2]);


if ($border) {
    $borderImage = ImageFilledRectangle($image, 0, 0, 0, 0, 000);
    imagesetthickness($image, $borderWidth);
    imagerectangle($image, 0, 0, ImageSX($image), ImageSY($image), $borderImage);
}

// set HTML Header

header(CONTENT_TYPE);

// Create the image
imagepng($image);

// destroy the image
imagedestroy($image);


// Functions

/**
 * Method to set the Boarder with var on error
 *
 * @param $borderWidth
 * @return int
 */
function checkBorderVar($borderWidth)
{
    if (empty($borderWidth) || !is_numeric($borderWidth)) {
        $borderWidth = 0;
        return $borderWidth;
    }
    return $borderWidth;
}

/**
 *
 * Function to turn hexString #FFFFFF into an RGB array
 *
 * @param $hexString
 * @return array
 */
function hexStringToRGB($hexString)
{
    if (strlen($hexString) == 3) {
        $red = hexdec(substr($hexString, 0, 1) . substr($hexString, 0, 1));
        $green = hexdec(substr($hexString, 1, 1) . substr($hexString, 1, 1));
        $blue = hexdec(substr($hexString, 2, 1) . substr($hexString, 2, 1));
    } else {
        $red = hexdec(substr($hexString, 0, 2));
        $green = hexdec(substr($hexString, 2, 2));
        $blue = hexdec(substr($hexString, 4, 2));
    }
    $rgb = array($red, $green, $blue);
    return $rgb;
}

/**
 *
 * Method to set the default RGB if failed.
 *
 * @return array
 */
function defaultRGB()
{
    $coloursRGB = hexStringToRGB(DEFAULT_FILL);
    return $coloursRGB;
}

?>
