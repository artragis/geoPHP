<?php

/**
 * extended DOMException to describe some more complex problem in a DOMXML doc.
 * @package geoPHP
 * @author artragis
 */
class BadXMLException extends \DOMException{
    const PARSE_ERROR    = 1;
    const WRONG_TYPE     = 2;
    const UNEXPECTED_TAG = 4;
}

?>
