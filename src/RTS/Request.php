<?php

namespace nvahalik\Rts\Api\RTS;

/**
 * Class Request
 * @package nvahalik\Rts\Api\RTS
 */
class Request implements RequestInterface {
  /**
   * @var \SimpleXMLElement
   */
  public $xml;
  /**
   * @var string Response class to create upon response.
   */
  public $responseClass = '';
  /**
   * Version of the API.
   */
  const VERSION = 1;

  /**
   * Constructor
   */
  public function __construct() {
    $this->xml = simplexml_load_string('<Request />');
    $this->xml->addChild('Version', self::VERSION);
    return $this;
  }

  /**
   * @param $path
   * @param $value
   */
  public function addSimplePath($path, $value) {
    $pathParts = explode('/', $path);
    $part = $this->xml;
    while ($thisOne = array_shift($pathParts)) {
      if (isset($part->{$thisOne})) {
        $part = $part->{$thisOne};
        continue;
      }
      $part = $part->addChild($thisOne, count($pathParts) != 0 ? null : $value);
    }
  }

  /**
   * @return int
   */
  public function length() {
    return strlen($this->asString());
  }

  /**
   * @return mixed
   */
  public function asString() {
    return $this->__toString();
  }

  /**
   * @return mixed
   */
  public function __toString() {
    return $this->xml->asXML();
  }

  /**
   * @return string
   */
  public function getResponseClass() {
    return $this->responseClass;
  }
}
