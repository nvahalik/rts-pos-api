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
  public function __construct($cardAmount, $creditCardNumber, $ccvCode, $expiration, $name, $street, $postal, $totalAmount = null) {
    parent::__construct();
    if ($totalAmount === null) {
      $totalAmount = $cardAmount;
    }
    $this->xml->addChild('Command', 'Buy');
    $this->addSimplePath('Data/Packet/PurchaseGifts/PurchaseGift/Amount', $cardAmount);
    $this->addSimplePath('Data/Packet/Payments/Payment/Type', 'CreditCard');
    $this->addSimplePath('Data/Packet/Payments/Payment/Number', $creditCardNumber);
    $this->addSimplePath('Data/Packet/Payments/Payment/CID', $ccvCode);
    $this->addSimplePath('Data/Packet/Payments/Payment/Expiration', $expiration);
    $this->addSimplePath('Data/Packet/Payments/Payment/AvsStreet', $street);
    $this->addSimplePath('Data/Packet/Payments/Payment/AvsPostal', $postal);
    $this->addSimplePath('Data/Packet/Payments/Payment/NameOnCard', $name);
    $this->addSimplePath('Data/Packet/Payments/Payment/ChargeAmount', $totalAmount);
    return $this;
  }

  public function addToGiftCard($giftcard) {
    $this->addSimplePath('Data/Packet/PurchaseGifts/PurchaseGift/GiftCard', $giftcard);
  }
}