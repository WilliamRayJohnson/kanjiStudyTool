<?php
    use PHPUnit\Framework\TestCase;
    
    /**
     * @covers Quizer
     */
    class QuizerTest extends TestCase {
        public function testConstructQuizer() : void {
            $testQuizer = new Quizer();
            $this->assertEquals(0, $testQuizer->questionCount());
            $this->assertFalse($testQuizer->isQuizComplete());
        }
        
        public function testAddQuestion() : void {
            $testQuizer = new Quizer();
            $testQuizer->addQuestion("test", array("test"), "test");
            $this->assertEquals(1, $testQuizer->questionCount());
            $currentQuestion = $testQuizer->getCurrentQuestion();
            $this->assertEquals(0, $currentQuestion->questionId);
            $this->assertFalse($testQuizer->isQuizComplete());
        }
        
        public function testAnswerCurrentQuestion() : void {
            $testQuizer = new Quizer();
            $testQuizer->addQuestion("test", array("test"), "test");
            $testQuizer->addQuestion("test2", array("test2"), "test2");
            $testQuizer->answerCurrentQuestion("answer");
            $currentQuestion = $testQuizer->getCurrentQuestion();
            $this->assertEquals(1, $currentQuestion->questionId);
        }
        
        public function testCycleQuiz() : void {
            $testQuizer = new Quizer();
            $testQuizer->addQuestion("test", array("test"), "test");
            $testQuizer->addQuestion("test2", array("test2"), "test2");
            $testQuizer->addQuestion("test3", array("test3"), "test3");
            $testQuizer->addQuestion("test4", array("test4"), "test4");
            
            $currentQuestion = $testQuizer->getCurrentQuestion();
            $this->assertEquals(0, $currentQuestion->questionId);
            
            $testQuizer->answerCurrentQuestion("answer");
            $currentQuestion = $testQuizer->getCurrentQuestion();
            $this->assertEquals(0, $currentQuestion->questionId);
            $testQuizer->answerCurrentQuestion("test");
            $currentQuestion = $testQuizer->getCurrentQuestion();
            $this->assertEquals(1, $currentQuestion->questionId);
            
            $testQuizer->answerCurrentQuestion("test2");
            $currentQuestion = $testQuizer->getCurrentQuestion();
            $this->assertEquals(2, $currentQuestion->questionId);

            $testQuizer->answerCurrentQuestion("incorrect");
            $currentQuestion = $testQuizer->getCurrentQuestion();
            $this->assertEquals(2, $currentQuestion->questionId);
            $testQuizer->answerCurrentQuestion("test3");
            $currentQuestion = $testQuizer->getCurrentQuestion();
            $this->assertEquals(3, $currentQuestion->questionId);

            $testQuizer->answerCurrentQuestion("test4");
            $currentQuestion = $testQuizer->getCurretnQuestion();
            $this->assertEquals(0, $currentQuestion->questionId);
            $this->assertFalse($testQuizer->isQuizComplete());

            $testQuizer->answerCurrentQuestion("test");
            $currentQuestion = $testQuizer->getCurrentQuestion();
            $this->assertEquals(2, $currentQuestion->questionId);
            $this->assertFalse($testQuizer->isQuizComplete());

            $testQuizer->answerCurrentQuestion("test3");
            $this->assertTrue($testQuizer->isQuizComplete());
        }
        
        public function testCompleteQuiz() : void {
            $testQuizer = new Quizer();
            $testQuizer->addQuestion("test", array("test"), "test");
            $testQuizer->addQuestion("test2", array("test2"), "test2");
            $testQuizer->answerCurrentQuestion("test");
            $this->assertEquals("test", $testQuizer->questions[0]->response);
            $testQuizer->answerCurrentQuestion("test2");
            $this->assertEquals("test2", $testQuizer->questions[1]->response);
            $this->assertTrue($testQuizer->isQuizComplete());
        }

        public function testAnswerIncorrectly() : void {
            $testQuizer = new Quizer();
            $testQuizer->addQuestion("test", array("test"), "test");
            $testQuizer->addQuestion("test2", array("test2"), "test2");
            $currentQ = $testQuizer->getCurrentQuestion();
            $this->assertEquals(0, $currentQ->questionId);
            $testQuizer->answerCurrentQuestion("test2");
            $this->assertEquals(0, $currentQ->questionId);
            $testQuizer->answerCurrentQuestion("test");
            $currentQ = $testQuizer->getCurrentQuestion();
            $this->assertEquals(1, $currentQ->questionId);
        }
    }
?>
