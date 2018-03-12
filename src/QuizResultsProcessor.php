<?php
define("QUIZ_MAX_CHANGE", "0.1");
define("PAST_MAX_CHANGE", "0.02");

class QuizResultsProcessor {
    const QUIZ_MAX_CHANGE = 0.1;
    const PAST_MAX_CHANGE = 0.02;
    
    function calcBasicRetentionScore($pastCR, $pastIR, $quizCR, $quizIR, $originalRetentionScore) {
        $quizRatio;
        $pastRatio;
        $newRetentionScore;
        
        if($pastCR > $pastIR) 
            $pastRatio = (float)$pastIR/(float)$pastCR;
        else if($pastIR >= $pastCR)
            $pastRatio = -(float)$pastCR/(float)$pastIR;
        if($quizCR > $quizIR) 
            $quizRatio = (float)$quizIR/(float)$quizCR;
        else if($quizIR >= $quizCR)
            $quizRatio = -(float)$quizCR/(float)$quizIR;
        
        $newRetentionScore = $originalRetentionScore + (QUIZ_MAX_CHANGE * $quizRatio) + (PAST_MAX_CHANGE * $pastRatio);
        
        if($newRetentionScore > 1.0)
            $newRetentionScore = 1.0;
        return $newRetentionScore;
    }
}

?>