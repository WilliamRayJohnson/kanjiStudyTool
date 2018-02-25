<?php
    class Question {
        var $questionId;
        var $question;
        var $answers;
        var $resposne;
        var $correctResponse;
        var $isAnswered;
        var $isAnsweredCorrectly;
        var $responseAttempts;
        
        function __construct($questionId, $question, $answers, $correctResponse) {
            $this->questionId = $questionId;
            $this->question = $question;
            $this->answers = $answers;
            $this->correctResponse = $correctResponse;
            $this->isAnswered = false;
            $this->isAnsweredCorrectly = false;
            $this->responseAttempts = 0;
        }
        
        function getFormattedQuestion() {
            $formattedQuestion =
            "<form name=\"question\" onSubmit=\"return submitResponse(" . $this->questionId . ")\">\n" .
            $this->question . "<br>\n";
            foreach($this->answers as $answer) {
                $formattedQuestion .= 
            "    <input type=\"radio\" name=\"q" . $this->questionId . "Option\" value=\"" . $answer . "\">" . $answer . "<br>\n";
            }
            $formattedQuestion .= 
            "    <input type=\"submit\" name=\"q" . $this->questionId . "submit\" value=\"Submit\">\n" .
            "</form>\n";
            
            return($formattedQuestion);
        }
        
        function answerQuestion($response) {
            $this->response = $response;
            $this->isAnswered = true;
            if($response == $this->correctResponse) {
                $isAnsweredCorrectly = true;
            }
            else {
                $isAnsweredCorrectly = false;
            }
            $this->responseAttempts++;
        }
        
        function hasResponse() {
            return($this->isAnswered);
        }
        
        function hasCorrectAnswer() {
            return($this->isAnsweredCorrectly);
        }
    }
?>