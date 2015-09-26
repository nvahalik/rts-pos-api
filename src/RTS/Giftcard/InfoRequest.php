<?php

namespace nvahalik\Rts\Api\RTS\Giftcard;

use nvahalik\Rts\Api\RTS\Request;

class InfoRequest extends Request {
  /**
   * @var string
   */
  public $responseClass = 'nvahalik\\Rts\\Api\\RTS\\InfoResponse';

  /**
   * @param string $gc
   */
  public function __construct($gc = '') {
    parent::__construct();
    $this->xml->addChild('Command', 'GiftInformation');
    return $this;
  }

  /**
   * @param $gc
   * @return $this
   */
  public function setGiftCard($gc) {
    $this->gc = $gc;
    $this->addSimplePath('Data/Packet/Giftcards/Giftcard', $gc);
    return $this;
  }
}
