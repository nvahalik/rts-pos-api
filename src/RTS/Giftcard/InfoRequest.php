<?php

namespace nvahalik\Rts\Api\RTS\Giftcard;

use nvahalik\Rts\Api\RTS\Request;

/**
 * Class InfoRequest
 * @package nvahalik\Rts\Api\RTS\Giftcard
 */
class InfoRequest extends Request {
  /**
   * @var string
   */
  public $responseClass = 'nvahalik\\Rts\\Api\\RTS\\Giftcard\\InfoResponse';

  /**
   * @var string
   *  The gift card passed into the request.
   */
  public $gc = '';

  /**
   * @param string $giftcard
   */
  public function __construct($giftcard = '') {
    parent::__construct();
    $this->gc = $giftcard;
    $this->xml->addChild('Command', 'GiftInformation');
    $this->addSimplePath('Data/Packet/GiftCards/GiftCard', $giftcard);
    return $this;
  }
}
