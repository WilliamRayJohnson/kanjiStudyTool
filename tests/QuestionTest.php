<?php
    use PHPUnit\Framework\TestCase;
    
    /**
     * @covers Question
     */
    class QuestionTest extends TestCase {
        public function testGetFormattedQuestion() : void {
            $expectedQuestion =
            "<form name=\"question\" onSubmit=\"return submitResponse(1)\">\n" .
            "test<br>\n" .
            "    <input type=\"radio\" name=\"q1Option\" value=\"test\">test<br>\n" .
            "    <input type=\"submit\" name=\"q1submit\" value=\"Submit\">\n" .
            "</form>\n";
            $testQuestion = new Question(1, "test", array("test"), "test");
            $actualQuestion = $testQuestion->getFormattedQuestion();
            $this->assertEquals($expectedQuestion, $actualQuestion);
        }
        
        public function testAnswerQuestion() : void {
            $testQuestion = new Question(1, "test", array("test"), "test");
            $testQuestion->answerQuestion("answer");
            $this->assertTrue($testQuestion->hasResponse());
            $this->assertFalse($testQuestion->hasCorrectAnswer());
            $this->assertEquals(1, $testQuestion->responseAttempts());
        }
        
        public function testAnswerQuestionCorrectly() : void {
            $testQuestion = new Question(1, "test", array("test"), "test");
            $testQuestion->answerQuestion("test");
            $this->assertTrue($testQuestion->hasCorrectAnswer());
        }

        public function testAnswerQuestionIncorrectly() : void {
            $testQuestion = new Question(1, "test", array("test"), "test");
            $testQuestion->answerQuestion("incorrect");
            $this->assertFalse($testQuestion->hasCorrectAnswer());
            $this->assertTrue($testQuestion->needsRepeatResponse());
        }

        public function testAnsQIncorrectThenCorrect() : void {
            $testQuestion = new Question(1, "test", array("test"), "test");
            $testQuestion->answerQuestion("incorrect");
            $this->assertTrue($testQuestion->needsRepeatResponse());
            $testQuestion->answerQuestion("test");
            $this->assertTrue($testQuestion->needsRepeatResponse());
            $this->assertTrue($testQuestion->hasCorrectAnswer());
            $this->assertEquals(2, $testQuestion->responseAttempts());
        }
        
        public function testCompleteAnsQIncorrWorkflow() {
            $testQuestion = new Question(1, "test", array("test"), "test");
            $testQuestion->answerQuestion("incorrect");
            $testQuestion->answerQuestion("test");
            $this->assertTrue($testQuestion->needsRepeatResponse());
            $this->assertTrue($testQuestion->hasCorrectAnswer());
            $testQuestion->answerQuestion("test");
            $this->assertFalse($testQuestion->needsRepeatResponse());
        }
        
        public function testConstructQuestion() : void {
            $testQuestion = new Question(1, "test", array("一", "二"), "一");
            $this->assertEquals(1, $testQuestion->questionId);
            $this->assertEquals("test", $testQuestion->question);
            $this->assertEquals("一", $testQuestion->answers[0]);
            $this->assertEquals("二", $testQuestion->answers[1]);
            $this->assertEquals("一", $testQuestion->correctResponse);
            $this->assertFalse($testQuestion->isAnswered);
            $this->assertFalse($testQuestion->isAnsweredCorrectly);
        }
    }  
?>
