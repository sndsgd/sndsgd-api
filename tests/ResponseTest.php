<?php

namespace sndsgd\api;


class ResponseTest extends \sndsgd\api\ResponseTestCase
{
   public function setUp()
   {
      $_SERVER['SERVER_PROTOCOL'] = 'HTTP 1.1';
      $this->res = new Response;
      $this->res->setStatusCode(200);
   }

   /**
    * @expectedException InvalidArgumentException
    */
   public function testSetStatusCodeInvalidCode()
   {
      $this->res->setStatusCode('asd');
   }

   public function testHeaders()
   {
      $this->res->addHeader('one', 1);
      $this->assertEquals(['one' => 1], $this->res->getHeaders());
      $this->res->addHeader('two', 'two');

      $expect = ['one' => 1, 'two' => 'two'];
      $this->assertEquals($expect, $this->res->getHeaders());
   }

   public function testGetStatuses()
   {
      $this->assertEquals(200, $this->res->getStatusCode());
      $this->assertEquals('OK', $this->res->getStatusText());
   }

   /**
    * @runInSeparateProcess
    */
   public function testSend()
   {
      $this->res->addHeader('x-one', 1);
      $this->res->addHeader('x-two', 'two');

      $this->res->send();
      $this->getAndTestHeaders(['HTTP 1.1 200 OK', 'x-one: 1', 'x-two: two']);
   }

   /**
    * @runInSeparateProcess
    */
   public function testSendBatch()
   {
      $responses = [
         (new Response(200))->addData('number', 1),
         (new Response(400))->addData('number', 2),
         (new Response(500))->addData('number', 3),
      ];

      Response::sendBatch('sndsgd\\api\\Response', $responses);

      $this->getAndTestHeaders(['HTTP 1.1 200 OK', 'X-Response-Count: 3']);
   }
}

