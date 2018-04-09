<?php
if(!isset($_SESSION["username"]))
    header('Location: index.php');
?>
<!DOCTYPE html>

<html>
    <head>
        <title>The Kanji Studier: Rate Kanji</title>
        <meta charset="utf-8" />
        
        <link rel="stylesheet" type="text/css" href="index.css" />
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    </head>

    <body>
        <?php include '../src/MenuBar.php'?>
        
        <div class="content">
            <h2 class="content-header">Please rate how well you think you know these kanji:</h2>
            <div class="content-block">
                <form name="qrating" action="submit-kanji.php" method="post">
                    <?php
                        $_SESSION["sourceToAdd"] = $_POST["source"];
                        include '../src/GetKanjiToRate.php';
                    ?>
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </body>
</html>
