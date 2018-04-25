<?php
    /**
    * The class that contains a question's state and describes
    * all question functionality
    */
    class Question {
        var $questionId;
        var $testItem;
        var $question;
        var $answers;
        var $resposne;
        var $correctResponse;
        var $isAnswered;
        var $isAnsweredCorrectly;
        var $repeatResponseNeeded;
        var $correctResponses;
        var $incorrectResponses;
        
        /**
        * Constructs a question in the state of a question
        * that has had no actions performed on iterator_apply
        * @param int $questionId The ID identifing the question
        * @param string $question The question to be asked
        * @param string $answers An array of possible answers to the question
        * @param string $correctResponse The correct answer
        * @param string $testItem the item being tested in the question
        */
        function __construct($questionId, $question, $answers, $correctResponse, $testItem) {
            $this->questionId = $questionId;
            $this->question = $question;
            $this->answers = $answers;
            $this->correctResponse = $correctResponse;
            $this->testItem = $testItem;
            $this->isAnswered = false;
            $this->isAnsweredCorrectly = false;
            $this->repeatResponseNeeded = false;
            $this->correctResponses = 0;
            $this->incorrectResponses = 0;
        }
        
        /**
        * Formats the question's data into an html form
        * @return string An html form that contains the data for the current 
        *       state of the question
        */
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
            "    </form>\n";
            if ($this->repeatResponseNeeded && !$this->isAnsweredCorrectly) {
                $formattedQuestion .=
                "<p style=\"color:red\">Sorry that response was incorrect, please try again</p>";
            }
            $formattedQuestion .=
            "</div>\n";
            
            return($formattedQuestion);
        }
        
        /**
        * Answers the question and changes state per the correctness of the answer
        * @param string $response The response given by the user
        */
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
        
        /**
        * Formats the question's data into a JSON
        * @return string The question in JSON format
        */
        function getJSON() {
            $JSON = sprintf("{\"kanji\": \"%s\", \"correct\": %d, \"incorrect\": %d}",
                            $this->testItem, $this->correctResponses, $this->incorrectResponses);
            return($JSON);
        }
        
        /**
        * @return bool True if question has an answer
        */
        function hasResponse() {
            return($this->isAnswered);
        }
        
        /**
        * @return bool True if question has been answered correctly
        */
        function hasCorrectAnswer() {
            return($this->isAnsweredCorrectly);
        }

        /**
        * @return bool True if the question needs to be presented again to the user
        */
        function needsRepeatResponse() {
            return($this->repeatResponseNeeded);
        }

        /**
        * @return int The total number of responses given
        */
        function responseAttempts() {
            return($this->correctResponses + $this->incorrectResponses);
        }
    }
?>
