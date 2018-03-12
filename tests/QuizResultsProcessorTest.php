<?php
    use PHPUnit\Framework\TestCase;
    
    /**
     * @covers ProcessQuizResults
     */
    class ProcessQuizResultsTest extends TestCase {
        public function testCalcBasicRetentionScoreIncrease() {
            $originalRetentionScore = 0.75;
            $pastCR = 10;
            $pastIR = 15;
            $quizCR = 1;
            $quizIR = 0;
            $newRetentionScore = QuizResultSProcessor::calcBasicRetentionScore(
                                    $pastCR, $pastIR, $quizCR, $quizIR, $originalRetentionScore);
            $this->assertTrue($newRetentionScore > $originalRetentionScore);
        }
        
        public function testCalcBasicRetentionScoreDecrease() {
            $originalRetentionScore = 0.75;
            $pastCR = 15;
            $pastIR = 10;
            $quizCR = 2;
            $quizIR = 3;
            $newRetentionScore = QuizResultSProcessor::calcBasicRetentionScore(
                                    $pastCR, $pastIR, $quizCR, $quizIR, $originalRetentionScore);
            $this->assertTrue($newRetentionScore < $originalRetentionScore);
        }
    }
?>