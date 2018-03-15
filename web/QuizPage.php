<?php
include '../src/Question.php';
include '../src/Quizer.php';
include '../src/QuizGenerator.php';
include '../src/DBAccessor.php';

session_start();

if(isset($_SESSION["isQuizing"])) {
    if(isset($_POST["answer"])) {
        $_SESSION["quiz"]->answerCurrentQuestion($_POST["answer"]);
        if($_SESSION["quiz"]->isQuizComplete())
            $_SESSION["isQuizing"] = false;
    }
    else {
        session_unset();
        session_destroy();
    }
}
else {
    $generator = new QuizGenerator();
    $quiz = $generator->generateQuiz("William", 5);
    $_SESSION["isQuizing"] = true;
    $_SESSION["quiz"] = $quiz;
}

print <<<TOP
<html>
    <head>
        <title>Quiz</title>
        <meta charset="utf-8" />
        
        <link rel="stylesheet" type="text/css" href="index.css" />
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
        <div class=content>
TOP;
    
        if($_SESSION["isQuizing"]){
            $currentQuestion = $_SESSION['quiz']->getCurrentQuestion();
            $formattedQuestion = $currentQuestion->getFormattedQuestion();
            print <<<QDIV
            <div class=question-block>
            $formattedQuestion
            </div>
QDIV;

        }
        else{
            $quizResults = $_SESSION["quiz"]->getJSON("William");
            print <<<SEND_RESULTS
            <script type="text/javascript">
            window.onload = sendQuizResults($quizResults);
            </script>
            Quiz is finished <br/>
            <a href=index.php>Return to home</a><br>
SEND_RESULTS;
            session_unset();
            session_destroy();
        }
        
print <<<BOTTOM
        </div>
    </body>
</html>
BOTTOM;
?>    