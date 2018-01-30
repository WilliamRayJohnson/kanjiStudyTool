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
            $dbInfo = include('config/config.php');
            $db = mysqli_connect($dbInfo['DB_SERVER'], $dbInfo['DB_USERNAME'], $dbInfo['DB_PASSWORD'], $dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            
            if (!$db) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql = "SELECT * FROM kanji";
            $result = mysqli_query($db, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<p>" . $row["kanji"] . "</p>";
                }
            }
            else {
                echo "0 results";
            }
            
            mysqli_close($db);
        ?>
        </div>
    </body>
</html>
