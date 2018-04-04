<!DOCTYPE html>
<?php
if(isset($_SESSION["username"]))
    ;
else
    $_SESSION["username"] = "William";
?>

<html>
    <head>
        <title>The Kanji Studier: Kanji Rated</title>
        <meta charset="utf-8" />
        
        <link rel="stylesheet" type="text/css" href="index.css" />
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    </head>

    <body>
        <?php include '../src/MenuBar.php'?>
        
        <div class="content">
            <div class="content-block">
                <?php
                    while($kanji = current($_POST)) {
                        echo key($_POST) . ": " . $kanji . '<br>';
                        next($_POST);
                    }
                ?>
            </div>
        </div>
    </body>
</html>