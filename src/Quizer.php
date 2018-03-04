<?php
    class Quizer {
        var $questions;
        var $currentQuestionIndex;
        
        function __construct() {
            $this->questions = array();
            $this->currentQuestionIndex = 0;
        }
        
        function questionCount() {
            return(count($this->questions));
        }
        
        function isQuizComplete() {
            $quizComplete = true;
            $qCount = count($this->questions);
            $currentQ = 0;
            if($qCount > 0) {
                while($quizComplete and $currentQ < $qCount) {
                    $quizComplete = $this->questions[$currentQ]->hasCorrectAnswer();
                    $currentQ++;
                }
            }
            else {
                $quizComplete = false;
            }
            return($quizComplete);
        }
        
        function addQuestion($question, $answers, $correctResponse) {
            array_push($this->questions, new Question(count($this->questions), $question, $answers, $correctResponse));
        }
        
        function getCurrentQuestion() {
            return($this->questions[$this->currentQuestionIndex]);
        }
        
        function answerCurrentQuestion($answer) {
            $this->questions[$this->currentQuestionIndex]->answerQuestion($answer);
            if($this->questions[$this->currentQuestionIndex]->hasCorrectAnswer()) {
                if($this->currentQuestionIndex == (count($this->questions) - 1)) {
                    $this->currentQuestionIndex = 0;
                }
                else {
                    $this->currentQuestionIndex++;
                }
            }
        }
    }
?>