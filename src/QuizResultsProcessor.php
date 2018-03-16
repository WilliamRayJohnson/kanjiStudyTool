<?php
define("QUIZ_MAX_CHANGE", "0.1");
define("PAST_MAX_CHANGE", "0.02");

/**
* A results processor for calculation of new retention scores
*/
class QuizResultsProcessor {
    const QUIZ_MAX_CHANGE = 0.1;
    const PAST_MAX_CHANGE = 0.02;
    
    /**
    * Calculates a basic retention score based on the ratio between
    * past correct/incorrect responses and the correct/incorrect responses given
    * in the quiz. Ratios favoring correct responses raise retention score while
    * ratios favoring incorrect responses lower retention score.
    * @param int $pastCR The total number of correct responses the user has given
    *       for a the question type
    * @param int $pastIR The total number of incorrect responses the user has given
    *       for a the question type
    * @param int $quizCR The number of correct responses given by the user in the
    *       current quizzing session for the question type
    * @param int $quizIR The number of incorrect responses given by the user in the
    *       current quizzing session for the question type
    * @param float $originalRetentionScore The current retention score of the question
    *       type
    * @return float The new retention score based on the new parameters
    */
    public static function calcBasicRetentionScore(
                    $pastCR, $pastIR, $quizCR, $quizIR, $originalRetentionScore) {
        $quizRatio;
        $pastRatio;
        $newRetentionScore;
        
        if($pastCR > $pastIR) {
            if($pastIR == 0)
                $pastIR++;
            if($pastCR == 0)
                $pastCR++;
            $pastRatio = (float)$pastIR/(float)$pastCR;
        }
        else if($pastIR >= $pastCR) {
            if($pastIR == 0)
                $pastIR++;
            if($pastCR == 0)
                $pastCR++;
            $pastRatio = -(float)$pastCR/(float)$pastIR;
        }
        if($quizCR > $quizIR) {
            if($quizIR == 0)
                $quizIR++;
            if($quizCR == 0)
                $quizCR++;
            $quizRatio = (float)$quizIR/(float)$quizCR;
        }
        else if($quizIR >= $quizCR) {
            if($quizIR == 0)
                $quizIR++;
            if($quizCR == 0)
                $quizCR++;
            $quizRatio = -(float)$quizCR/(float)$quizIR;
        }
        
        $newRetentionScore = $originalRetentionScore + (QUIZ_MAX_CHANGE * $quizRatio) + (PAST_MAX_CHANGE * $pastRatio);
        
        if($newRetentionScore > 1.0)
            $newRetentionScore = 1.0;
        return $newRetentionScore;
    }
}
?>