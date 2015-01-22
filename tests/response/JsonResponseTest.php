<?php

namespace sndsgd\api\response;

use \sndsgd\Json;


class JsonResponseTest extends \sndsgd\api\ResponseTestCase
{
   protected $responseData = [
      'integer' => 42,
      'float' => 4.2,
      'string' => 'two',
      'slashes' => "/escape/me"
   ];

   public function setUp()
   {
      $_SERVER['SERVER_PROTOCOL'] = 'HTTP 1.1';
      $this->res = new JsonResponse;
      $this->res->setStatusCode(200);
   }

   /**
    * @runInSeparateProcess
    */
   public function testSetEncodeOptions()
   {
      $this->res->setData($this->responseData);
      $this->res->setEncodeOptions(Json::HUMAN);
      $this->res->send();

      $expect = json_encode($this->responseData, Json::HUMAN);
      $this->expectOutputString($expect);
   }

   /**
    * @runInSeparateProcess
    */
   public function testSend()
   {
      $this->res->setData($this->responseData);
      $this->res->send();

      $expect = json_encode($this->responseData);
      $this->expectOutputString($expect);
      
      $this->getAndTestHeaders([
         'HTTP 1.1 200 OK',
         'Content-Type: application/json',
         'Content-Length: '.strlen($expect)
      ]);
   }
}

