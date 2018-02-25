<?php
    use PHPUnit\Framework\TestCase;
    
    /**
     * @covers Question
     */
    class QuestionTest extends TestCase {
        public function testGetFormattedQuestion() : void {
            $expectedQuestion =
            "<form>\n" .
            "test<br>\n" .
            "    <input type=\"radio\" name=\"qOption\" value=\"test\">test<br>\n" .
            "</form>\n";
            $testQuestion = new Question("test", array("test"));
            $actualQuestion = $testQuestion->getFormattedQuestion();
            $this->assertEquals($expectedQuestion, $actualQuestion);
        }
        
        public function testHasResponse() : void {
            $testQuestion = new Question("test", array("test"));
            $testQuestion->answerQuestion("answer");
            $this->assertTrue($testQuestion->hasResponse());
        }
    }  
?>