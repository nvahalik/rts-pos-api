<?php

namespace nvahalik\Rts\Api\RTS;

use nvahalik\Rts\Api\RTS as RTS;

/**
 * Class Giftcard
 * @package Nvahalik\Rts\Api\RTS
 */
class Giftcard {
  private $parent;

  public function __construct(RTS $parent) {
    $this->parent = $parent;
  }
  /**
   *
   */
  public function purchase() {

  }

  /**
   * Grabs information about a gift card.
   *
   * @param $giftcard string
   */
  public function get($giftcard) {
    $request = new RTS\Giftcard\InfoRequest($giftcard);
    $this->parent->call($request);
  }
}