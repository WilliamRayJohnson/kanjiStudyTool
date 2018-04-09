<?php
if(!isset($_SESSION["username"]))
    header('Location: index.php');
?>
<!DOCTYPE html>

<html>
    <head>
        <title>The Kanji Studier: Quiz Setup</title>
        <meta charset="utf-8" />

        <link rel="stylesheet" type="text/css" href="index.css" />
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    </head>

    <body>
        <?php include '../src/MenuBar.php'?>

        <div class="content">
            <div class="content-block">
                <h2 class="content-header">Please choose quiz options</h2>
                <form action="quiz-page.php" method="post">
                    <label for="questionCount">Question Count:</label>
                    <select id="questionCount" name="questionCount">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                    <br>
                    <input type="submit" value="Submit" style="width: 100%">
                </form>
            </div>
        </div>
    </body>
</html>
