<?php

namespace Nvahalik\Rts\Api\RTS;

interface RequestInterface  {
  /**
   * @return string Text class name of the class that will handle the response.
   */
  public function getResponseClass();
  /**
   * @return String representation of the request to be made.
   */
  public function asString();

  public function length();
}