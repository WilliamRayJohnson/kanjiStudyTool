<!DOCTYPE html>

<html>
    <head>
        <title>Hello, World</title>
        <meta charset="utf-8" />
        
        <link rel="stylesheet" type="text/css" href="index.css" />
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
        $( function() {
            $( "#selectable" ).selectable();
        } );
        </script>
    </head>

    <body>
        <?php
            include 'src/Question.php';
            
            $aQuestion = new Question("Test", array("test"));
            echo $aQuestion->getFormattedQuestion();
        ?>
    </body>
</html>
