<?php

require_once 'Foo.php';

//use Stuff\dummyPHP;
//use Stuff\dummyPHP\Foo;

class FooTest extends \PHPUnit\Framework\TestCase
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