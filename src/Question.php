<?php
    class Question {
        var $question;
        var $answers;
        
        function __construct($question, $answers) {
            $this->question = $question;
            $this->answers = $answers;
        }
        
        function getFormattedQuestion() {
            $formattedQuestion = 
            "<div>\n" .
            "    <h2>" . $this->question . "</h2>\n" .
            "    <ol id=\"selectable\">\n";
            foreach($this->answers as $answer) {
                $formattedQuestion .= 
            "        <li class=\"ui-widget-content\">" . $answer . "</li>\n";
            }
            $formattedQuestion .= 
            "    </ol>\n" .
            "</div>";
            
            return($formattedQuestion);
        }
    }
?>