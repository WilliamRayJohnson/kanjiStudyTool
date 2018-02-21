<?php
    use PHPUnit\Framework\TestCase;
    
    /**
     * @covers Question
     */
    class QuestionTest extends TestCase {
        public function testGetFormattedQuestion() : void {
            $expectedQuestion =
            "<h2 align=\"left\">test</h2>\n" .
            "<ol id=\"selectable\">\n" .
            "    <li class=\"ui-widget-content\">test</li>\n" .
            "</ol>";
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