<?php
define("ANSWER_COUNT", "4");

/**
* A quiz generator for various types of quizzes
*/
class QuizGenerator {
    const ANSWER_COUNT = 4;

    var $accessor;

    /**
    * Constructs a quiz generator with an DBAccessor per
    * the config.php
    */
    function __construct() {
        $dbInfo = include('../config/config.php');
        $this->accessor = new DBAccessor($dbInfo);
    }

    /**
    * Generates a quiz for a user of a given length.
    * Questions will contain kanji and will ask for the
    * appropriate hiragana reading.
    * @param string $username The user the quiz is for
    * @param int $questionCount The number of questions to ask
    * @return Quizer A new quiz ready to be presented
    */
    function generateQuiz($username, $questionCount) {
        $quizQuestions;
        $quizAnswers;
        $quiz = new Quizer();
        
        $quizQuestions = $this->accessor->getQuizQuestions($username, $questionCount);
        foreach($quizQuestions as $question) {
            $quizAnswers = $this->accessor->getQuizAnswers($question["qKanji"],
                                    $question["qWord"], ANSWER_COUNT - 1)["readings"];
            array_push($quizAnswers, $question["qReading"]);
            shuffle($quizAnswers);
            $quiz->addQuestion(sprintf("How is %s read?", $question["qWord"]),
                    $quizAnswers, $question["qReading"], $question["qKanji"]);
        }
        
        return($quiz);
    }
}
?>