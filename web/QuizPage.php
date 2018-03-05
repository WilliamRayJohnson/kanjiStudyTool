<?php
include '../src/Question.php';
include '../src/Quizer.php';

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
    $quiz = new Quizer();
    $quiz->addQuestion("Question 1: 一", array("いち", "に", "さん", "よん"), "いち");
    $quiz->addQuestion("Question 2: 日本", array("ひとり", "にほん", "にち", "にっぽん"), "にほん");
    $quiz->addQuestion("Question 3: 今日", array("ひ", "きょう", "あした", "まえ"), "きょう");
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
                    $('html').html(data);
                });
            return false;
        }
        </script>
    </head>
    
    <body>
        <div align="center">
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
            echo "Quiz is finished <br/>";
            session_unset();
            session_destroy();
        }
        
print <<<BOTTOM
        </div>
    </body>
</html>
BOTTOM;
?>    