<?php

namespace sndsgd\api\response;

use \sndsgd\Json;


class JsonResponseTest extends \PHPUnit_Framework_TestCase
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
      $this->res = new JsonResponse(200);
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
      $headers = xdebug_get_headers();
      $this->assertEquals('HTTP 1.1 200 OK', $headers[0]);
      $this->assertEquals('Content-Type: application/json', $headers[1]);

      $expect = json_encode($this->responseData);
      $this->expectOutputString($expect);
      
   }
}

