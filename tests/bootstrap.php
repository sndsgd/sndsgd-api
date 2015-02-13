<?php

namespace sndsgd\api;

use \sndsgd\Str;


require __DIR__."/../vendor/autoload.php";


class ResponseTestCase extends \PHPUnit_Framework_TestCase
{
   protected function getAndTestHeaders(array $expect)
   {
      if (extension_loaded("xdebug")) {
         $headers = xdebug_get_headers();
         for ($i=0, $len=count($expect); $i<$len; $i++) {
            $expectHeader = strtolower($expect[$i]);
            $realHeader = strtolower($headers[$i]);

            // the content type header can include the charset (;charset=UTF-8)
            if (Str::beginsWith($expectHeader, "content-type:")) {
               $realHeader = substr($realHeader, 0, strlen($expectHeader));
               $this->assertEquals($expectHeader, $realHeader);
            }
            else {
               $this->assertEquals($expectHeader, $realHeader);   
            }
         }
      }
   }
}

