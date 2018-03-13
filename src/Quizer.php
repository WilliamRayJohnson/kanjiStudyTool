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
                    $correctAnswer = $this->questions[$currentQ]->hasCorrectAnswer();
                    $noRepeatResponse = !$this->questions[$currentQ]->needsRepeatResponse();
                    $quizComplete = $correctAnswer && $noRepeatResponse;
                    $currentQ++;
                }
            }
            else {
                $quizComplete = false;
            }
            return($quizComplete);
        }
        
        function addQuestion($question, $answers, $correctResponse, $testItem) {
            array_push($this->questions, new Question(count($this->questions), $question, $answers, $correctResponse, $testItem));
        }
        
        function getCurrentQuestion() {
            $indexOnValidQuestion = false;
            while(!$indexOnValidQuestion) {
                $currentQ = $this->questions[$this->currentQuestionIndex];
                if($currentQ->hasCorrectAnswer() && !$currentQ->needsRepeatResponse()) {
                    $this->currentQuestionIndex++;
                }
                else {
                    $indexOnValidQuestion = true;
                }
            }
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
        
        function getJSON($username) {
            $JSON = sprintf("{\"username\": \"%s\", \"questionCount\": %d, \"questions\": [",
                            $username, count($this->questions));
            $JSONQuestions = "";
            foreach($this->questions as $question)
                $JSONQuestions = sprintf("%s%s,", $JSONQuestions, $question->getJSON());
            $JSONQuestions = trim($JSONQuestions, ",");
            $JSON = sprintf("%s%s]}", $JSON, $JSONQuestions);
            return($JSON);
        }
    }
?>