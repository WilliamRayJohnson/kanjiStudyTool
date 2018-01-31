<?php
    /*
        An accessor that that provides all necessary queries to the kanji_studier DB.
    */
    class DBAccessor {
        var $dbInfo;
        
        function __construct($dbInfo) {
            $this->dbInfo = $dbInfo;
        }
        
        function displayAllKanji() {
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'], $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            
            if (!$db) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $file = fopen('sql/GET_ALL_KANJI.sql', "r+");
            $sql = fread($file, filesize($file));
            
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
        }
    }
?>