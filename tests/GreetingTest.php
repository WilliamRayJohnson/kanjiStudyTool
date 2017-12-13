<?php
    use PHPUnit\Framework\TestCase;
    
    /**
     * @covers Greeting
     */
    class GreetingTest extends TestCase {
        public function testSayHello() : void {
            $this->assertEquals('<p>Hello!</p>', Greeting::sayHello());
        }
    }
    
?>