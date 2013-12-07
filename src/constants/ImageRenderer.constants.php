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


/**
 * Constants used within the ImageRenderer Class, these are used as the defaults, in case the
 * setting of the class fields used to render the image fail due to not being valid.
 */


define("DEFAULT_BORDER", 4);
define("DEFAULT_FILL", "DCDADA");
define("DELIMITER", ",");
define("RGB_COUNT", 3);
define("HEX_LENGTH", 6);
define("CONTENT_TYPE", "Content-type: image/png");
define("SHOW_BORDER", false);
define("FONT_PATH", 'fonts/monofont.ttf');



define("SIZE_JOINER","x");
define("GET_PARAM",'url');

?>