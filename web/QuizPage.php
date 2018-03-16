<?php
include '../src/Question.php';
include '../src/Quizer.php';
include '../src/QuizGenerator.php';
include '../src/DBAccessor.php';

session_start();

if(isset($_SESSION["username"])) {
    if(isset($_SESSION["isQuizing"])) {
        if(isset($_POST["answer"])) {
            $_SESSION["quiz"]->answerCurrentQuestion($_POST["answer"]);
            if($_SESSION["quiz"]->isQuizComplete())
                $_SESSION["isQuizing"] = false;
        }
    }
    else {
        $generator = new QuizGenerator();
        $quiz = $generator->generateQuiz($_SESSION["username"], 5);
        $_SESSION["isQuizing"] = true;
        $_SESSION["quiz"] = $quiz;
    }
}
?>

<html>
    <head>
        <title>The Kanji Studier: Quiz</title>
        <meta charset="utf-8" />
        
        <link rel="stylesheet" type="text/css" href="index.css" />
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script type="text/javascript">
        function submitResponse(questionId) {
            $.post("QuizPage.php",
            {answer: $('input[name=q' + questionId + 'Option]:checked').val()},
                function(data){
                    document.write(data);
                    document.close();
                });
            return false;
        }
        function sendQuizResults(results) {
            $.post("scripts/ProcessQuizResults.php", results);
            return false;
        }
        </script>
    </head>
    
    <body>
        <?php include '../src/MenuBar.php'?>
        
        <div class="content">
        
        <?php
        if(isset($_SESSION["username"])) {
            if($_SESSION["isQuizing"]){
                $currentQuestion = $_SESSION['quiz']->getCurrentQuestion();
                $formattedQuestion = $currentQuestion->getFormattedQuestion();
                print <<<QDIV
                <div class=question-block>
                $formattedQuestion
                </div>
QDIV;

            }
            else if($_SESSION["quiz"]->isQuizComplete()){
                $quizResults = $_SESSION["quiz"]->getJSON($_SESSION["username"]);
                unset($_SESSION["quiz"], $_SESSION["isQuizing"]);
                print <<<SEND_RESULTS
                <script type="text/javascript">
                window.onload = sendQuizResults($quizResults);
                </script>
                <h2 style="margin: auto">Quiz is finished </h2>
                <a class="content-button" href=index.php>Return to home</a>
SEND_RESULTS;

            }
        }
        else {
            print <<<LOGIN
            <a class="content-button" href=index.php>Please Login</a>
LOGIN;

        }
        ?>
        
        </div>
    </body>
</html>  