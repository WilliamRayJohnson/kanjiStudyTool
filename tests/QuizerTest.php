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
            $testQuizer->answerCurrentQuestion("answer");
            $currentQuestion = $testQuizer->getCurrentQuestion();
            $this->assertEquals(1, $currentQuestion->questionId);
            $testQuizer->answerCurrentQuestion("answer2");
            $currentQuestion = $testQuizer->getCurrentQuestion();
            $this->assertEquals(0, $currentQuestion->questionId);
            $this->assertFalse($testQuizer->isQuizComplete());
        }
        
        public function testCompleteQuiz() : void {
            $testQuizer = new Quizer();
            $testQuizer->addQuestion("test", array("test"), "test");
            $testQuizer->addQuestion("test2", array("test2"), "test2");
            $testQuizer->answerCurrentQuestion("test");
            $testQuizer->answerCurrentQuestion("test2");
            $this->assertTrue($testQuizer->isQuizComplete());
        }
    }
?>