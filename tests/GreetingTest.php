<?php
    use PHPUnit\Framework\TestCase;
    
    include '../src/Greeting.php';
    
    /**
     * @covers Greeting
     */
    class GreetingTest extends TestCase {
        public function testSayHello() : void {
            $this->assertEquals('<p>Hello!</p>', Greeting::sayHello());
        }
        
        public function testSayGreeting() : void {
            $this->assertEquals('<p>Salut!</p>', Greeting::sayGreeting('Salut!'));
        }
    }
    
?>