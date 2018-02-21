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
            "<h2 align=\"left\">" . $this->question . "</h2>\n" .
            "<ol id=\"selectable\">\n";
            foreach($this->answers as $answer) {
                $formattedQuestion .= 
            "    <li class=\"ui-widget-content\">" . $answer . "</li>\n";
            }
            $formattedQuestion .= 
            "</ol>";
            
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