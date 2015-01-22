<?php

namespace sndsgd\api;

use \InvalidArgumentException;
use \sndsgd\http\Code as HttpCode;


class Response
{
   use \sndsgd\data\Manager;
   
   /**
    * Send multiple responses as one array of responses
    *
    * @param string $class The classname of the response instance to send
    * @param array.<sndsgd\api\Response> $responses
    */
   public static function sendBatch($class, array $responses)
   {
      $data = [];
      foreach ($responses as $res) {
         $data[] = [
            $res->getStatusCode(),
            $res->getStatusText(),
            $res->getHeaders(),
            $res->getData()
         ];
      }

      $response = new $class(200);
      $response->addHeader('X-Response-Count', count($data));
      $response->setData($data);
      $response->send();
   }

   /** 
    * The response status code
    * 
    * @var integer
    */
   protected $statusCode;

   /** 
    * The response status text
    * 
    * @var string
    */
   protected $statusText;

   /** 
    * Custom response headers are stored here
    * 
    * @var array.<string,string|number>
    */
   protected $headers = [];

   /**
    * Create a new response
    * 
    * @param integer $code An http status code
    */
   public function __construct($code)
   {
      $this->statusCode = $code;
      $this->statusText = HttpCode::getStatusText($code);
      if ($this->statusText === null) {
         throw new InvalidArgumentException("invalid HTTP code '$code'");
      }
   }

   /**
    * Set a header
    * 
    * @param string $key The header name
    * @param string|integer $value The header value
    * @return sndsgd\api\Response
    */
   public function addHeader($key, $value)
   {
      $this->headers[$key] = $value;
      return $this;
   }

   /**
    * Get headers
    * 
    * @return array.<string,string|number>
    */
   public function getHeaders()
   {
      return $this->headers;
   }

   /**
    * Get the http status code
    * 
    * @return integer
    */
   public function getStatusCode()
   {
      return $this->statusCode;
   }

   /**
    * Get the http status text
    * 
    * @return string
    */
   public function getStatusText()
   {
      return $this->statusText;
   }

   /**
    * Send the response to the client
    * 
    * @return void
    */
   public function send()
   {
      header(
         $_SERVER['SERVER_PROTOCOL'].' '. // HTTP 1.1
         $this->statusCode.' '. // 200
         $this->statusText // OK
      );
      foreach ($this->headers as $key => $value) {
         header($key.': '.$value);
      }
   }
}


