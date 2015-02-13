<?php

namespace sndsgd\api\response;


class RawResponseTest extends \sndsgd\api\ResponseTestCase
{
   protected $responseBody = "example response body\n\nfor testing purposes\n";

   public function setUp()
   {
      $_SERVER["SERVER_PROTOCOL"] = "HTTP 1.1";
      $this->res = new RawResponse;
      $this->res->setStatusCode(200);
   }

   /**
    * @runInSeparateProcess
    */
   public function test()
   {
      $this->res->setBody($this->responseBody, "text/plain");
      $this->res->send();

      $this->expectOutputString($this->responseBody);
      $this->getAndTestHeaders([
         "HTTP 1.1 200 OK",
         "Content-Type: text/plain",
         "Content-Length: ".strlen($this->responseBody)
      ]);
   }
}

