<?php

namespace sndsgd\api;


require __DIR__.'/../vendor/autoload.php';


class ResponseTestCase extends \PHPUnit_Framework_TestCase
{
   protected function getAndTestHeaders(array $expect)
   {
      if (extension_loaded('xdebug')) {
         $headers = xdebug_get_headers();
         for ($i=0, $len=count($expect); $i<$len; $i++) {
            $this->assertEquals($expect[$i], $headers[$i]);
         }
      }
   }
}

