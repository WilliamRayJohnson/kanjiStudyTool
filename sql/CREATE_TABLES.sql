/*These are the set of tables to be used in the Kanji Studier Project*/

CREATE TABLE kanji_source (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    source VARCHAR(40));

CREATE TABLE kanji (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    kanji VARCHAR(1) UNIQUE KEY,
    source_id INT,
    INDEX (source_id),
    FOREIGN KEY (source_id)
        REFERENCES kanji_source(id)
        ON UPDATE CASCADE ON DELETE RESTRICT);

CREATE TABLE word (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    word VARCHAR(10) UNIQUE KEY,
    reading VARCHAR(20));

CREATE TABLE kanji_in_word (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    word_id INT,
    kanji_id INT,
    INDEX (word_id),
    INDEX (kanji_id),
    FOREIGN KEY (word_id)
        REFERENCES word(id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (kanji_id)
        REFERENCES kanji(id)
        ON UPDATE CASCADE ON DELETE CASCADE);

CREATE TABLE student (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(30),
    creation_date DATE,
    last_login DATE);

CREATE TABLE student_kanji (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    kanji_id INT,
    INDEX (student_id),
    INDEX (kanji_id),
    FOREIGN KEY (student_id)
        REFERENCES student(id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (kanji_id)
        REFERENCES kanji(id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    retention_score FLOAT,
    correct_response_count INT,
    incorrect_response_count INT,
    last_time_quized DATE);
