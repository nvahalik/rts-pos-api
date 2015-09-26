<?php

namespace nvahalik\Rts\Api\RTS;

class Request implements RequestInterface {
  /**
   * @var \SimpleXMLElement
   */
  public $xml;
  /**
   * @var string Response class to create upon response.
   */
  public $responseClass = '';

  const VERSION = 1;

  public function __construct() {
    $this->xml = simplexml_load_string('<Request />');
    $this->xml->addChild('Version', self::VERSION);
    return $this;
  }

  public function addSimplePath($path, $value) {
    $pathParts = explode('/', $path);
    $part = $this->xml;
    while ($thisOne = array_shift($pathParts)) {
      $part = $part->addChild($thisOne, count($pathParts)==0 ?: $value);
    }
  }

  public function length() {
    return strlen($this->asString());
  }

  public function asString() {
    return $this->__toString();
  }

  public function __toString() {
    return $this->xml->asXML();
  }

  public function getResponseClass() {
    return $this->responseClass;
  }

}