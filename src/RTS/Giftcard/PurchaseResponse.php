<?php
/**
 * Gift card purchase response class
 *
 * @author     Nick Vahalik <nick@nickvahalik.com>
 * @copyright  2015 Nicholas Vahalik
 * @license    http://www.gnu.org/licenses/gpl.html
 */

namespace nvahalik\Rts\Api\RTS\Giftcard;

use nvahalik\Rts\Api\RTS\Response;

/**
 * Class PurchaseResponse
 * @package nvahalik\Rts\Api\RTS\Giftcard
 */
class PurchaseResponse extends Response {
  /**
   * @var array
   *  Custom Xpath maps for variables.
   */
  protected $_customMapping = [
    'giftCardNumber' => 'Packet/Response/GiftPurchases/GiftPurchase/GiftNumber',
    'transactionId' => 'Packet/Response/TransactionID',
    'amount' => 'Packet/Response/GiftPurchases/GiftPurchase/Amount',
    'responseText' => 'Packet/Response/ResponseText',
  ];

  /**
   * Returns the 16 digit gift card code assigned by the POS system.
   * @return string
   */
  public function giftCardNumber() {
    return $this->giftCardNumber;
  }

  /**
   * Return the transaction ID. Should be numeric.
   * @return mixed
   */
  public function transactionId() {
    return $this->transactionId;
  }

  /**
   * Returns the amount on the card.
   * @return float
   */
  public function amount() {
    return $this->amount;
  }

  /**
   * Returns the response text string from the POS system.
   * @return string
   */
  public function responseText() {
    return $this->responseText;
  }


}
