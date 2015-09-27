<?php

namespace nvahalik\Rts\Api\RTS\Giftcard;

use nvahalik\Rts\Api\RTS\Request;

class PurchaseRequest extends Request {
  /**
   * @var string
   */
  public $responseClass = 'nvahalik\\Rts\\Api\\RTS\\Giftcard\\PurchaseResponse';

  /**
   * @param string $giftcard
   */
  public function __construct($amount, $creditCardNumber, $ccvCode, $expiration, $name, $street, $postal) {
    parent::__construct();
    $this->amount = $amount;
    $this->xml->addChild('Command', 'Buy');
    $this->addSimplePath('Data/Packet/PurchaseGifts/PurchaseGift/Amount', $amount);
    $this->addSimplePath('Data/Packet/Payments/Payment/Type', 'CreditCard');
    $this->addSimplePath('Data/Packet/Payments/Payment/Number', $creditCardNumber);
    $this->addSimplePath('Data/Packet/Payments/Payment/CID', $ccvCode);
    $this->addSimplePath('Data/Packet/Payments/Payment/Expiration', $expiration);
    $this->addSimplePath('Data/Packet/Payments/Payment/AvsStreet', $street);
    $this->addSimplePath('Data/Packet/Payments/Payment/AvsPostal', $postal);
    $this->addSimplePath('Data/Packet/Payments/Payment/NameOnCard', $name);
    $this->addSimplePath('Data/Packet/Payments/Payment/ChargeAmount', $amount);
    return $this;
  }

  public function addToGiftCard($giftcard) {
    $this->addSimplePath('Data/Packet/PurchaseGifts/PurchaseGift/GiftCard', $giftcard);
  }
}