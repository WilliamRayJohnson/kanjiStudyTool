SELECT sk.retention_score, sk.total_questions_asked
    FROM student_kanji sk
    JOIN student s ON s.id = sk.student_id
    JOIN kanji k ON k.id = sk.kanji_id
    WHERE k.kanji = ? AND s.username = ?