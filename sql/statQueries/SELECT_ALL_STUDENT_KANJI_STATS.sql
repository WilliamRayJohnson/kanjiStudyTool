SELECT s.name, k.kanji, sk.retention_score, sk.total_questions_asked,
    sk.last_time_quized
    FROM student_kanji sk
    JOIN kanji k ON k.id = sk.kanji_id
    JOIN student s ON sk.student_id=s.id
    WHERE s.name = "William"
    ORDER BY sk.retention_score;