<?php

namespace Nvahalik\Rts\Api\RTS\Giftcard;

use Nvahalik\Rts\Api\RTS\Request;

class InfoRequest extends Request {
  /**
   * @var string
   */
  public $responseClass = 'RTS_GiftInformationResponse';

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
