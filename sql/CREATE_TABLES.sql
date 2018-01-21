/*These are the set of tables to be used in the Kanji Studier Project*/

CREATE TABLE kanji (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    kanji VARCHAR(1),
    source_id INT);

CREATE TABLE word (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    word VARCHAR(10),
    reading VARCHAR(20));

CREATE TABLE kanji_in_word (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    word_id INT,
    kanji_id INT);

CREATE TABLE kanji_source (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    source VARCHAR(40));

CREATE TABLE student (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(30),
    creation_date DATE,
    last_login DATE);

CREATE TABLE student_kanji (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    stduent_id INT,
    kanji_id INT,
    retention_score FLOAT,
    correct_response_count INT,
    incorrect_response_count INT,
    last_time_quized DATE);
