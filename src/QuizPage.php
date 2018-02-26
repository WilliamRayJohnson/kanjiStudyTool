<?php
include 'Question.php';
include 'Quizer.php';


print <<<TOP
<html>
    <head>
        <title>Quiz</title>
        <meta charset="utf-8" />
        
        <link rel="stylesheet" type="text/css" href="../web/index.css" />
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript">
        function submitResponse(questionId) {
            alert("You chose: " + $('input[name=q' + questionId + 'Option]:checked').val());
            return false;
        }
        </script>
    </head>
    
    <body>
        <div align="center">
TOP;
        $quiz = new Quizer();
        $quiz->addQuestion("Question 1:", array("一", "二"), "一");
        $quiz->addQuestion("Question 2:", array("三", "四"), "四");
        
        foreach($quiz->questions as $question) {
        print <<<QDIV
            <div class=question-block>
            $question->getFormattedQuestion()
            </div>
QDIV;
        }
    
    
print <<<BOTTOM
        </div>
    </body>
</html>
BOTTOM;
?>    