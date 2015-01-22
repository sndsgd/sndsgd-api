<?php

namespace sndsgd\api\response;

use \sndsgd\Json;


/**
 * An API response encoded as JSON
 */
class JsonResponse extends \sndsgd\api\Response
{
   /**
    * JSON encode options
    * 
    * @var integer
    */
   protected $encodeOptions = 0;

   /**
    * Set encode options to pass to json_encode
    * 
    * @param integer $options A bitmask of JSON_* constants
    */
   public function setEncodeOptions($options)
   {
      $this->encodeOptions = $options;
   }

   /**
    * {@inheritdoc}
    */
   public function send()
   {
      parent::send();
      header('Content-Type: application/json');
      $payload = $this->getData();
      $payload = (empty($payload))
         ? '{}'
         : json_encode($payload, $this->encodeOptions);
      header('Content-Length: '.strlen($payload));
      echo $payload;
   }
}

