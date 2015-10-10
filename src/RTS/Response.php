<?php

namespace nvahalik\Rts\Api\RTS;

/**
 * Class Response
 * @package nvahalik\Rts\Api\RTS
 */
class Response {
  /**
   * @var
   */
  public $_xml;
  /**
   * @var
   */
  private $_data;

  /**
   * @var array
   */
  private $_mapping = array(
    'code' => '/Response/Code',
    'version' => '/Response/Version',
    'error_text' => '/Response/ErrorText',
  );

  /**
   * @var array
   *  Custom Xpath maps for variables.
   */
  protected $_customMapping = array();

  /**
   * @param string $xml
   */
  public function __construct($xml = '') {
    $this->_superMap = array_merge($this->_mapping, $this->_customMapping);

    if (!empty($xml)) {
      $this->setXml($xml);
    }

    if ($this->hasError()) {
      throw new \Exception($this->error_text, $this->code);
    }

    return $this;
  }

  /**
   * @param $xml
   */
  function setXml($xml) {
    $this->_xml = simplexml_load_string($xml);
  }

  /**
   * @param $value
   * @return null
   */
  public function __get($value) {
    if (empty($this->_data[$value])) {
      $xpathValue = $this->_xml->xpath($this->getPath($value));
      if (empty($xpathValue)) return null;
      $this->_data[$value] = (string)$xpathValue[0];
    }
    return $this->_data[$value];
  }

  /**
   * @param $value
   * @return mixed
   */
  protected function getPath($value) {
    return $this->_superMap[$value];
  }

  /**
   * @return bool
   */
  public function hasError() {
    return ((int)$this->__get('code') !== -1);
  }

  /**
   * @return string
   */
  public function getError() {
    return $this->__get('error_text');
  }

  /**
   * @return string
   */
  public function __toString() {
    return $this->_xml->asXML();
  }

  /**
   * @return string
   */
  public function asString() {
    return $this->__toString();
  }
}
