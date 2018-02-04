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
        <div align="center">
        <?php
            include '../src/DBAccessor.php';
            $dbInfo = include('../config/config.php');
            
            $accessor = new DBAccessor($dbInfo);
            
            $words = $accessor->getWordsWithKanji(1);
            
            foreach($words as $word) {
                echo $word[0], $word[1], '<br>';
            }
        ?>
        </div>
    </body>
</html>
