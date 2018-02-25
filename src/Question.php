<?php
    class Question {
        var $question;
        var $answers;
        var $resposne;
        var $hasAnswer;
        
        function __construct($question, $answers) {
            $this->question = $question;
            $this->answers = $answers;
        }
        
        function getFormattedQuestion() {
            $formattedQuestion =
            "<form>\n" .
            $this->question . "<br>\n";
            foreach($this->answers as $answer) {
                $formattedQuestion .= 
            "    <input type=\"radio\" name=\"qOption\" value=\"" . $answer . "\">" . $answer . "<br>\n";
            }
            $formattedQuestion .= 
            "</form>\n";
            
            return($formattedQuestion);
        }
        
        function answerQuestion($response) {
            $this->response = $response;
            $this->hasAnswer = true;
        }
        
        function hasResponse() {
            return($this->hasAnswer);
        }
    }
?>