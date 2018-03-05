<?php
    class Question {
        var $questionId;
        var $question;
        var $answers;
        var $resposne;
        var $correctResponse;
        var $isAnswered;
        var $isAnsweredCorrectly;
        var $repeatResponseNeeded;
        var $correctResponses;
        var $incorrectResponses;
        
        function __construct($questionId, $question, $answers, $correctResponse) {
            $this->questionId = $questionId;
            $this->question = $question;
            $this->answers = $answers;
            $this->correctResponse = $correctResponse;
            $this->isAnswered = false;
            $this->isAnsweredCorrectly = false;
            $this->repeatResponseNeeded = false;
            $this->correctResponses = 0;
            $this->incorrectResponses = 0;
        }
        
        function getFormattedQuestion() {
            $formattedQuestion =
            "<h2 class=quiz-question>" . $this->question . "</h2>\n" .
            "<div class=quiz-answers>\n" .
            "    <form name=\"question\" onSubmit=\"return submitResponse(" . $this->questionId . ")\">\n";
            foreach($this->answers as $answer) {
                $formattedQuestion .= 
            "        <input type=\"radio\" name=\"q" . $this->questionId . "Option\" value=\"" . $answer . "\">" . $answer . "<br>\n";
            }
            $formattedQuestion .= 
            "        <input type=\"submit\" name=\"q" . $this->questionId . "submit\" value=\"Submit\">\n" .
            "    </form>\n" .
            "</div>\n";
            
            return($formattedQuestion);
        }
        
        function answerQuestion($response) {
            if(!$this->isAnsweredCorrectly || $this->repeatResponseNeeded) {
                $this->response = $response;
                $this->isAnswered = true;
                if($response == $this->correctResponse) {
                    if($this->correctResponses >= 1 && $this->repeatResponseNeeded)
                        $this->repeatResponseNeeded = false;
                    $this->isAnsweredCorrectly = true;
                    $this->correctResponses++;
                }
                else {
                    $this->isAnsweredCorrectly = false;
                    $this->repeatResponseNeeded = true;
                    $this->incorrectResponses++;
                }
            }
        }
        
        function hasResponse() {
            return($this->isAnswered);
        }
        
        function hasCorrectAnswer() {
            return($this->isAnsweredCorrectly);
        }

        function needsRepeatResponse() {
            return($this->repeatResponseNeeded);
        }

        function responseAttempts() {
            return($this->correctResponses + $this->incorrectResponses);
        }
    }
?>
