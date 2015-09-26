<?php

namespace Nvahalik\Rts\Api;
use Nvahalik\Rts\Api\RTS\RequestInterface;

/**
 * Implements the basic functions to access the RTS API.
 *
 * As of January 2015, this class no longer requires the more involved
 * authentication method that was previous needed to access the server. Basic
 * HTTP authentication can now be used.
 */
class RTS {
  /**
   * @var string RTS Point of sale system hostname or IP
   */
  protected $host = '';
  /**
   * @var int RTS Destination port. Should default to 2235.
   */
  protected $port = 2235;
  /**
   * @var string Endpoint posting requests.
   */
  protected $file = 'Data.ASP';
  /**
   * @var string Username for API Calls.
   */
  private $_username;
  /**
   * @var string Password for API Calls.
   */
  private $_password;
  /**
   * @var
   */
  private $_request;
  /**
   * @var resource Curl instance.
   */
  private $curl;

  /**
   * Constructor method.
   *
   * @param Array $options
   *   Default options for the class.
   */
  public function __construct(Array $options = []) {
    if (empty($options)) {
      return $this;
    }

    if (!empty($options['username'])) {
      $this->_username = $options['username'];
    }
    if (!empty($options['password'])) {
      $this->_password = $options['password'];
    }
    if (!empty($options['request'])) {
      $this->_request = $options['request'];
    }
    if (!empty($options['host'])) {
      $this->host = $options['host'];
    }
    if (!empty($options['port'])) {
      $this->port = $options['port'];
    }
    if (!empty($options['file'])) {
      $this->file = $options['file'];
    }

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
    curl_setopt($curl, CURLOPT_USERPWD, $this->_username . ':' . $this->_password);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($curl, CURLOPT_URL, $this->getRequestUrl());
    curl_setopt($curl, CURLOPT_PORT, $this->port);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POST, 1);
    $this->curl = $curl;

    return $this;
  }

  /**
   * Return the proper request URL.
   * @return string
   */
  public function getRequestUrl() {
    return 'https://' . $this->host . '/' . $this->file;
  }

  /**
   * @param $request RequestInterface The request to process.
   * @return mixed Response class.
   * @throws \Exception
   */
  public function call(RequestInterface $request) {
    $curl = $this->curl;

    $headers = [
      sprintf('Host: %s:%d', $this->host, $this->port),
      sprintf('Content-Length: %d', $request->length()),
      'Expect: 100-continue'
    ];

    // Set our headers.
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    // Set the request information.
    curl_setopt($curl, CURLOPT_POSTFIELDS, $request->asString());

    $str = curl_exec($curl);

    $rc = $this->_request->getResponseClass();
    if (!empty($str) && !empty($rc) && class_exists($rc)) {
      return new $rc($str);
    } else {
      throw new Exception('Invalid response returned.');
    }
  }

}

/**
 * Class RTS_GiftInformationResponse
 */
class RTS_GiftInformationResponse extends RTS_Response {
  /**
   * @var array
   */
  protected $_customMapping = array(
    'balance' => '/Response/Packet/GiftCard/DebitRemain',
    'registered' => '/Response/Packet/GiftCard/Registered'
  );
}

/**
 * Class RTS_PurchaseCardRequest
 */
class RTS_PurchaseCardRequest extends RTS_Request {

  /**
   * @var
   */
  public $card_number;
  /**
   * @var
   */
  public $expiration_date;
  /**
   * @var
   */
  public $street;
  /**
   * @var
   */
  public $cid;
  /**
   * @var int
   */
  public $amount = 0;
  /**
   * @var int
   */
  public $fee = 0;
  /**
   * @var
   */
  public $zip;

  /**
   * @param $number
   * @return $this
   */
  public function setCardNumber($number) {
    $this->card_number = $number;
    return $this;
  }

  /**
   * @param $date
   * @return $this
   */
  public function setExpirationDate($date) {
    $this->expiration_date = $date;
    return $this;
  }

  /**
   * @param $street
   * @return $this
   */
  public function setStreet($street) {
    $this->street = $street;
    return $this;
  }

  /**
   * @param $cid
   * @return $this
   */
  public function setCid($cid) {
    $this->cid = $cid;
    return $this;
  }

  /**
   * @param $amount
   * @return $this
   */
  public function setAmount($amount) {
    $this->amount = $amount;
    return $this;
  }

  /**
   * @param $fee
   * @return $this
   */
  public function setFee($fee) {
    $this->fee = $fee;
    return $this;
  }

  /**
   * @param $zip
   * @return $this
   */
  public function setZip($zip) {
    $this->zip = $zip;
    return $this;
  }

  /**
   * @param $name
   * @return $this
   */
  public function setName($name) {
    $this->name = $name;
    return $this;
  }

  /**
   * @return int
   */
  public function getTotal() {
    return $this->getFee() + $this->getAmount();
  }

  /**
   * @return int
   */
  public function getAmount() { return $this->amount; }

  /**
   * @return mixed
   */
  public function getCardNumber() { return $this->card_number; }

  /**
   * @return mixed
   */
  public function getExpirationDate() { return $this->expiration_date; }

  /**
   * @return mixed
   */
  public function getStreet() { return $this->street; }

  /**
   * @return mixed
   */
  public function getCid() { return $this->cid; }

  /**
   * @return int
   */
  public function getFee() { return $this->fee; }

  /**
   * @return mixed
   */
  public function getZip() { return $this->zip; }

  /**
   * @return mixed
   */
  public function getName() { return $this->name; }

  /**
   * @var string
   */
  protected $responseClass = 'RTS_PurchaseCardResponse';

  /**
   * @return string
   */
  public function __toString() {
    $xml  = "<Request>";
    $xml .=     "<Version>1</Version>";
    $xml .=     "<Command>Buy</Command>";
    $xml .=     "<Data>";
    $xml .=         "<Packet>";
    $xml .=             "<PurchaseGifts>";
    $xml .=                 "<PurchaseGift>";
    $xml .=                     "<Amount>{$this->getAmount()}</Amount>";
    $xml .=                 "</PurchaseGift>";
    $xml .=             "</PurchaseGifts>";
    if ($this->getFee()) {
      $xml .=         "<Fees>";
      $xml .=             "<TransactionFee>{$this->getFee()}</TransactionFee>";
      $xml .=         "</Fees>";
    }
    $xml .=             "<Payments>";
    $xml .=                 "<Payment>";
    $xml .=                     "<Type>CreditCard</Type>";
    $xml .=                     "<Number>{$this->getCardNumber()}</Number>";
    $xml .=                     "<Expiration>{$this->getExpirationDate()}</Expiration>";
    $xml .=                     "<AvsStreet>{$this->getStreet()}</AvsStreet>";
    $xml .=                     "<AvsPostal>{$this->getZip()}</AvsPostal>";
    $xml .=                     "<CID>{$this->getCid()}</CID>";
    $xml .=                     "<NameOnCard>{$this->getName()}</NameOnCard>";
    $xml .=                     "<ChargeAmount>{$this->getTotal()}</ChargeAmount>";
    $xml .=                 "</Payment>";
    $xml .=             "</Payments>";
    $xml .=         "</Packet>";
    $xml .=     "</Data>";
    $xml .= "</Request>";
    return $xml;
  }
}


/**
 * Class RTS_PurchaseCardResponse
 */
class RTS_PurchaseCardResponse extends RTS_Response {
  /**
   * @var array
   */
  protected $_customMapping = array(
    'transaction_id' => '/Response/Packet/Response/TransactionID',
    'card_number' => '/Response/Packet/Response/GiftPurchases/GiftPurchase/GiftNumber'

  );
}