<?php
    use PHPUnit\Framework\TestCase;
    
    /**
     * @covers Question
     */
    class QuestionTest extends TestCase {
        public function testGetFormattedQuestion() : void {
            $expectedQuestion = 
            "<div>\n" .
            "    <h2>test</h2>\n" .
            "    <ol id=\"selectable\">\n" .
            "        <li class=\"ui-widget-content\">test</li>\n" .
            "    </ol>\n" .
            "</div>";
            $testQuestion = new Question("test", array("test"));
            $actualQuestion = $testQuestion->getFormattedQuestion();
            $this->assertEquals($expectedQuestion, $actualQuestion);
        }
    }  
?>