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
    * @param int $totalQuestionsAsked The total number of questions asked for this
    *       kanji that is recorded in the database
    * @param int $quizCR The number of correct responses given by the user in the
    *       current quizzing session for the question type
    * @param int $quizIR The number of incorrect responses given by the user in the
    *       current quizzing session for the question type
    * @param float $currentRetentionScore The current retention score of the question
    *       type
    * @return float The new retention score based on the new parameters
    */
    public static function calcBasicRetentionScore(
                    $totalQuestionsAsked, $quizCR, $quizIR, $currentRetentionScore) {
        $newRetentionScore = ($currentRetentionScore + ($quizCR/($quizCR + quizIR)))/($totalQuestionsAsked + 1);
        
        return $newRetentionScore;
    }
}
?>