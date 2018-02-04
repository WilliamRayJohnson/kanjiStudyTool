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
        
        /*
            Adds a word and its reading to the DB.
        */
        function addWord($word, $reading) {
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'], $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            
            if (!$db) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql = "CALL add_word(" . $word . "," . $reading . ")";
            mysqli_query($db, $sql);

            mysqli_close($db);
        }
        
        /*
            Adds a kanji to the DB.
        */
        function addKanji($kanji, $source_id) {
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'], $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            
            if (!$db) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql = "CALL add_kanji(" . $kanji . "," . $source_id . ")";
            mysqli_query($db, $sql);

            mysqli_close($db);
        }
        
        /*
            Adds a source to the DB.
        */
        function addSource($source_name) {
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'], $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            
            if (!$db) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql = "CALL add_source(" . $source_name . ")";
            mysqli_query($db, $sql);

            mysqli_close($db);
        }
    }
?>