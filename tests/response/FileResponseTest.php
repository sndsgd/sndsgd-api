<?php

namespace sndsgd\api\response;

use \sndsgd\Path;


class FileResponseTest extends \sndsgd\api\ResponseTestCase
{
   public function setUp()
   {
      $_SERVER["SERVER_PROTOCOL"] = "HTTP 1.1";
      $this->path = Path::normalize(__DIR__."/../test.png");
      $this->res = new FileResponse;
      $this->res->setStatusCode(200);
   }

   /**
    * @expectedException InvalidArgumentException
    */
   public function testSetPathInvalidPath()
   {
      $badPath = dirname($this->path)."/does-not-exist.txt";
      $this->res->setPath($badPath);
   }

   /**
    * @runInSeparateProcess
    */
   public function test()
   {
      $this->res->setPath($this->path);
      $this->res->send();

      $this->expectOutputString(file_get_contents($this->path));
      $this->getAndTestHeaders([
         "HTTP 1.1 200 OK",
         "Content-Type: image/png",
         "Content-Length: ".filesize($this->path)
      ]);
   }
}

