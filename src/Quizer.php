<?php
    class Quizer {
        var $questions;
        var $currentQuestionIndex;
        
        function __construct() {
            $this->questions = array();
        }
        
        function questionCount() {
            return(count($this->questions));
        }
        
        function isQuizComplete() {
            return(false);
        }
    }
?>