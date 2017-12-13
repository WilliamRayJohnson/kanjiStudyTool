<!DOCTYPE html>

<html>
    <head>
        <title>Hello, World</title>
        <meta charset="utf-8" />
        
        <link rel="stylesheet" type="text/css" href="index.css" />
        <style>
        #feedback { font-size: 1.4em; }
        #selectable .ui-selecting { background: #FECA40; }
        #selectable .ui-selected { background: #F39814; color: white; }
        #selectable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
        #selectable li { margin: 3px; padding: 0.4em; font-size: 1.4em; height: 18px; }
        </style>
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
