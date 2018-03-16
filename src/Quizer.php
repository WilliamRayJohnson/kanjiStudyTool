<?php
    /**
    * A quizzer that handles all functionality relating
    * to interating through a quiz
    */
    class Quizer {
        var $questions;
        var $currentQuestionIndex;
        
        /**
        * Constructs an empty quiz
        */
        function __construct() {
            $this->questions = array();
            $this->currentQuestionIndex = 0;
        }
        
        /**
        * @return int The number of questions contained in the quiz
        */
        function questionCount() {
            return(count($this->questions));
        }
        
        /**
        * Determines if the quiz is complete by checking the status of each question
        * @return bool True if the quiz is complete
        */
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
        
        /**
        * Adds a question to the quiz
        * @param string $question The question to be asked
        * @param string $answers An array of possible answers to the question
        * @param string $correctResponse The correct answer
        * @param string $testItem the item being tested in the question
        */
        function addQuestion($question, $answers, $correctResponse, $testItem) {
            array_push($this->questions, new Question(count($this->questions), $question, $answers, $correctResponse, $testItem));
        }
        
        /**
        * Retrieves the current question that needs to be presented to the
        * user
        * @return Question The question the quiz is currently on
        */
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
        
        /**
        * Answers the current question
        * @param string $answer the answer given for the question
        */
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
        
        /**
        * Formats the quiz into a JSON
        * @return string The quiz in JSON format
        */
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