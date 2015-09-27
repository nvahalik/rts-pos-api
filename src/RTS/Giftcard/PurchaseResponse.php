<?php

namespace nvahalik\Rts\Api\RTS\Giftcard;

use nvahalik\Rts\Api\RTS\Response;

class PurchaseResponse extends Response {
  protected $_customMapping = [
    'giftCardNumber' => 'Packet/Response/GiftPurchases/GiftPurchase/GiftNumber',
    'transactionId' => 'Packet/Response/TransactionID',
    'amount' => 'Packet/Response/GiftPurchases/GiftPurchase/Amount',
    'responseText' => 'Packet/Response/ResponseText',
  ];
}
