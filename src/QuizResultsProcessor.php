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
    * Calculates a basic retention score based on the current retention score,
    * the number of incorrect and correct responses for the most recent question asked,
    * the total number of times the question has been asked in the past. The value
    * calculated is essentially a recalculation of an average without knowing all of the values
    * that contributed to the average.
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
        $estimatedTotalScore = $currentRetentionScore * $totalQuestionsAsked;
        $newRetentionScore = ($estimatedTotalScore + ($quizCR/($quizCR + quizIR)))/($totalQuestionsAsked + 1);
        
        return $newRetentionScore;
    }
}
?>