<?php

namespace nvahalik\Rts\Api;

use nvahalik\Rts\Api\RTS\RequestInterface;

/**
 * Implements the basic functions to access the RTS API.
 *
 * As of January 2015, this class no longer requires the more involved
 * authentication method that was previous needed to access the server. Basic
 * HTTP authentication can now be used.
 */
class Client {
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
   * @var resource Curl instance.
   */
  private $curl;

  /**
   * Constructor method.
   *
   * @param Array $options
   *   Default options for the class.
   */
  public function __construct($username, $password, $host = '', $port = 2235) {
    $this->_username = $username;
    $this->_password = $password;
    $this->host = $host;
    $this->port = $port;

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
