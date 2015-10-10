<?php

namespace nvahalik\Rts\Api\RTS\Giftcard;

use nvahalik\Rts\Api\RTS\Request;

/**
 * Class PurchaseRequest
 * @package nvahalik\Rts\Api\RTS\Giftcard
 */
class PurchaseRequest extends Request {
  /**
   * @var string
   */
  public $responseClass = 'nvahalik\\Rts\\Api\\RTS\\Giftcard\\PurchaseResponse';

  /**
   * Constructor method.
   * @param $cardAmount
   * @param $creditCardNumber
   * @param $ccvCode
   * @param $expiration
   * @param $name
   * @param $street
   * @param $postal
   * @param $totalAmount (defaults to the $cardAmount);
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

  /**
   * @param $fee
   * @return $this
   */
  public function addFee($fee) {
    $this->addSimplePath('Data/Packet/Fees/TransactionFee', $fee);
    return $this;
  }

  /**
   * @param $giftcard
   * @return $this
   */
  public function addToGiftCard($giftcard) {
    $this->addSimplePath('Data/Packet/PurchaseGifts/PurchaseGift/GiftCard', $giftcard);
    return $this;
  }
}