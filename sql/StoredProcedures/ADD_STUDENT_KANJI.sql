CREATE PROCEDURE `add_student_kanji` (IN student_id INT, IN kanji_id INT)
BEGIN
    INSERT INTO `student_kanji` (`id`, `student_id`, `kanji_id`, `retention_score`, `total_questions_asked`, `last_time_quized`)
        VALUES (NULL, student_id, kanji_id, 0.0, 0, NOW());
END