<!DOCTYPE html>

<html>
    <head>
        <title>Hello, World</title>
        <meta charset="utf-8" />
        
        <link rel="stylesheet" type="text/css" href="index.css" />
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
        <?php
            include '../src/DBAccessor.php';
            include '../src/Question.php';
            $dbInfo = include('../config/config.php');
            
            $question = new Question(1, "Testing getting a response", array("一", "二"), "一");
            
            echo "<div class=question-block>";
            echo $question->getFormattedQuestion();
            echo "</div>";
        ?>
        </div>
    </body>
</html>
