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

require_once __DIR__ . '/../constants/colour.constants.php';

class Colour
{

    private $colourRepresentationString = null;

    /**
     * @param bool $newColourRepresentationString
     */
    function __construct($newColourRepresentationString = false)
    {
        if (!empty($newColourRepresentationString)) {
            $this->setColour($newColourRepresentationString);
        }
    }

    /**
     * @param $newColourRepresentationString
     */
    public function setColour($newColourRepresentationString)
    {
        if ($this->doValidation($newColourRepresentationString)) {
            $this->colourRepresentationString = $newColourRepresentationString;
        } else {
            $this->notValidColour($newColourRepresentationString);
        }

    }

    /**
     * @param bool $newColourRepresentationString
     * @return bool
     */
    private function doValidation($newColourRepresentationString = false)
    {
        $value = (!empty($newColourRepresentationString)) ? $newColourRepresentationString : $this->getColour();
        if (preg_match(REGEX_HEX, $value) || preg_match(REGEX_RGB, $value)) {
            return true;
        }

        return false;
    }

    /**
     * @return null
     */
    public function getColour()
    {
        return $this->colourRepresentationString;
    }

    /**
     * Method to throw an exception if the colour value is not a valid format.
     *
     * @throws InvalidArgumentException
     */
    private function notValidColour($newColourRepresentationString = false)
    {
        $colour = (!empty($newColourRepresentationString)) ? $newColourRepresentationString : $this->getColour();
        throw new InvalidArgumentException("Colour {$colour} is not a valid value");
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->doValidation();
    }

    /**
     * @return null
     */
    public function convertToRGB()
    {
        if ($this->doValidation()) {
            if (preg_match(REGEX_RGB, $this->colourRepresentationString)) {
                return $this->getColour();
            } else {
                $this->setColour($this->fromHex());
                return $this->getColour();
            }
        }

        $this->notValidColour();
    }

    /**
     * @return null
     */
    private function fromHex()
    {
        $this->colourRepresentationString = sscanf($this->colourRepresentationString, SCAN_HEX);

        $localArray = $this->getColour();
        foreach ($localArray as &$value) {
            $value = $this->zeroOut($value);
        }

        $this->setColour(implode(RGB_DELIMITER, $localArray));
        return $this->getColour();
    }

    /**
     * @param $var
     * @return mixed
     */
    private function zeroOut($var)
    {
        if (strlen($var) < MIN_RGB_SIZE) {
            $var = 0 . $var;
            return $this->zeroOut($var);
        }

        return $var;

    }

    /**
     * @return null
     */
    public function convertToHexString()
    {
        if ($this->doValidation()) {
            if (preg_match(REGEX_HEX, $this->colourRepresentationString)) {
                return $this->colourRepresentationString;
            } else {
                $this->setColour($this->fromRGB(explode(RGB_DELIMITER, $this->getColour())));
                return $this->getColour();
            }
        }

        $this->notValidColour();
    }

    /**
     * @param array $colours RGB values (1,3,94)
     * @return string HexString value for the passed RGB colour.
     */
    private function fromRGB(array $colours)
    {
        $colourString = null;

        foreach ($colours as $value) {
            if ($value != 0) {
                $colourString .= dechex($value);
                continue;
            }
            $colourString .= "00";
        }

        return $colourString;
    }

    public static function isValidRequest($value, Colour &$object)
    {
        if (preg_match_all(REGEX_HEX, $value, $matches) || preg_match_all(REGEX_RGB, $value, $matches)) {
            $object = new Colour($value);
            return true;
        }

        return false;
    }
}