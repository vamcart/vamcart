<?php

//require_once '../Vendor/autoload.php';

use Stuff\dummyPHP;
use Stuff\dummyPHP\Foo;

class FooTest extends PHPUnit_Framework_TestCase
{

    public function testThatBarReturnsBar()
    {
        $this->assertEquals('bar', Foo::bar());
    }
     
    public function testCaseSensitiveBar()
    {
        $this->assertNotEquals('Bar', Foo::bar());
    }        
}