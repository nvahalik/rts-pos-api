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
   * @var array
   */
  protected $_customMapping = [
    'balance' => 'Packet/GiftCard/DebitRemain',
    'registered' => 'Packet/GiftCard/Registered',
  ];
  public $balance;
  public $registered;
}