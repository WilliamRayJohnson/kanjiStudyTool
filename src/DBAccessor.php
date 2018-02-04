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
        }
        
        /*
            Retrives all words and readings that a kanji is contained within given a kanji_id.
        */
        function getWordsWithKanji($kanjiID) {
            $wordsAndReadings = array();
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'], $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            
            if (!$db) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql = "CALL get_words_containing_kanji(" . $kanjiID . ")";
            $result = mysqli_query($db, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $wordsAndReadings[] = array($row["word"], $row["reading"]);
                }
            }
            
            mysqli_close($db);
            
            return $wordsAndReadings;
        }
    }
?>