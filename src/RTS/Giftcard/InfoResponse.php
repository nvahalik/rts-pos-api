<?php

namespace nvahalik\Rts\Api\RTS\Giftcard;

use nvahalik\Rts\Api\RTS\Response;

/**
 * Class InfoResponse
 *
 * @package nvahalik\Rts\Api\RTS\Giftcard
 */
class InfoResponse extends Response {
  /**
   * @inheritdoc
   */
  protected $_customMapping = [
    'balance' => 'Packet/GiftCard/DebitRemain',
    'registered' => 'Packet/GiftCard/Registered',
  ];

  /**
   * Return the balance remaining on a card.
   * @return float
   */
  public function balance() {
    return $this->balance;
  }

  /**
   * Return true if the card is registered.
   * @return boolean
   */
  public function registered() {
    return boolval($this->registered);
  }
}
