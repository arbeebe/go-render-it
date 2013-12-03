<?php


require_once __DIR__ . '/../constants/colour.constants.php';

class Colour
{

    private $colourRepresentationString = null;

    function __construct($newColourRepresentationString = false)
    {
        $this->colourRepresentationString = $newColourRepresentationString;
    }

    public function isValid()
    {
        return $this->doValidation();
    }

    private function doValidation()
    {
        if (preg_match(REGEX_HEX, $this->getColour()) || preg_match(REGEX_RGB, $this->getColour())) {
            return true;
        }

        return false;
    }

    public function getColour()
    {
        return $this->colourRepresentationString;
    }

    public function convertToRGB()
    {
        if ($this->doValidation()) {
            if (preg_match(REGEX_RGB, $this->colourRepresentationString)) {
                return $this->colourRepresentationString;
            } else {
                $this->setColour($this->fromHex());
                return $this->getColour();
            }
        }

        throw new InvalidArgumentException("Colour {$this->colourRepresentationString} is not a valid value");
    }

    public function setColour($newColourRepresentationString)
    {
        $this->colourRepresentationString = $newColourRepresentationString;
    }

    private function fromHex()
    {
        $this->colourRepresentationString = sscanf($this->colourRepresentationString, "%02x%02x%02x");
        return "{$this->colourRepresentationString[0]},{$this->colourRepresentationString[1]},{$this->colourRepresentationString[2]}";
    }

    public function convertToHexString()
    {

        if ($this->doValidation()) {
            if (preg_match(REGEX_HEX, $this->colourRepresentationString)) {
                return $this->colourRepresentationString;
            } else {
                $this->setColour($this->fromRGB(explode(',', $this->getColour())));
                return $this->getColour();
            }
        }

        throw new InvalidArgumentException("Colour {$this->colourRepresentationString} is not a valid value");
    }

    private function fromRGB(array $colours)
    {
        $red = dechex($colours[0]);
        $green = dechex($colours[1]);
        $blue = dechex($colours[2]);

        return $red . $green . $blue;
    }
}