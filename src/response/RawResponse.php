<?php

namespace sndsgd\api\response;


/**
 * A response for sending raw resources to the client
 */
class RawResponse extends \sndsgd\api\Response
{
   /**
    * The response body
    * 
    * @var string
    */
   protected $body;

   /**
    * Set the response body
    * 
    * @param string $body The response body
    * @param string $contentType The appropriate mimetype for the re
    */
   public function setBody($body, $contentType)
   {
      $this->body = $body;
      $this->addHeader("Content-Type", $contentType);
   }

   /**
    * {@inheritdoc}
    */
   public function send()
   {
      parent::send();
      header("Content-Length: ".strlen($this->body));
      echo $this->body;
   }
}

