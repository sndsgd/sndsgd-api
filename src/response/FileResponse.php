<?php

namespace sndsgd\api\response;

use \InvalidArgumentException;
use \sndsgd\File;
use \sndsgd\Mime;


/**
 * A response for sending a file to clients
 */
class FileResponse extends \sndsgd\api\Response
{
   /**
    * Absolute path to the file
    * 
    * @var string
    */
   protected $path;

   /**
    * Set the path to the file
    * 
    * @param string $path
    * @param string|null $contentType
    */
   public function setPath($path, $contentType = null)
   {
      if (($test = File::isReadable($path)) !== true) {
         throw new InvalidArgumentException(
            "invalid value provided for 'path'; $test"
         );
      }

      $this->path = $path;   
      if ($contentType === null) {
         $ext = pathinfo($path, PATHINFO_EXTENSION);
         $contentType = Mime::getTypeFromExtension($ext);
      }
      $this->addHeader("Content-Type", $contentType);
   }

   /**
    * {@inheritdoc}
    */
   public function send()
   {
      parent::send();
      header("Content-Length: ".filesize($this->path));
      readfile($this->path);
   }
}

