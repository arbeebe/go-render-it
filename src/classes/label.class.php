<?php

require_once __DIR__ . "/../constants/label.constants.php";
class Label
{

    private $labelText = "";

    function __construct($labelText = false)
    {
        if($labelText)
        $this->labelText = $labelText;
    }


    public static function isValidRequest($value, Label &$labelObject)
    {
        if (preg_match_all(LABEL_REGEX, $value, $matches)) {
            $labelObject = new Label();
            $labelObject->setLabelText(str_replace(LABEL_ID, EMPTY_STRING, $value));
            return true;
        }

        return false;
    }

    public function createLabelTextFromSize(Size $size)
    {
        $this->setLabelText($size->getWidth() . "x" . $size->getHeight());
    }

    public function getLabelText()
    {
        return $this->labelText;
    }

    public function setLabelText($string)
    {
        $this->labelText = $string;
    }

    public function renderText(ImageRenderer &$imageObject)
    {
        $color = imagecolorallocate($imageObject->getResource(), 255, 255, 255);
        $grey = imagecolorallocate($imageObject->getResource(), 128, 128, 128);

        $font_size = 1;
        $txt_max_width = intval(0.5 * $imageObject->getSize()->getWidth());
        $txt_max_height = intval(0.5 * $imageObject->getSize()->getHeight());

        do {
            $font_size++;
            $p = imagettfbbox($font_size, 0, FONT_PATH, $this->getLabelText());
            $txt_width = $p[2] - $p[0];
            $txt_height = $p[1] - $p[7];

        } while (($txt_width <= $txt_max_width) && ($txt_height <= $txt_max_height));

        $ascent = abs($p[7]);
        $descent = abs($p[1]);
        $height = $ascent + $descent;

        $y = (($imageObject->getSize()->getHeight() / 2) - ($height / 2)) + $ascent;
        $x = ($imageObject->getSize()->getWidth() - $txt_width) / 2;
        imagettftext($imageObject->getResource(), $font_size, 0, $x, $y + 3, $grey, FONT_PATH, $this->getLabelText());
        imagettftext($imageObject->getResource(), $font_size, 0, $x, $y, $color, FONT_PATH, $this->getLabelText());
    }
}

?>