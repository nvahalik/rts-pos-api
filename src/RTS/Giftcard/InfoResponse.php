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
   * @var float
   *   Balance remaining on the card.
   */
  public $balance;
  /**
   * @var boolean
   *   True if the card is registered, false if not.
   */
  public $registered;


  /**
   * Implement getter magic function.
   * @param $key
   * @return mixed
   */
  public function __get($key) {
    $value = parent::__get($key);

    if ($value == 'registered') {
      return boolval($value);
    }

    return $value;
  }
}
