INSERT INTO `student_kanji` (`student_id`, `kanji_id`,
        `retention_score`, `total_questions_asked`, `last_time_quized`)
    SELECT s.id, k.id, ?, 1, NOW()
        FROM student s
        CROSS JOIN kanji k
        WHERE s.username = ? AND k.kanji = ?