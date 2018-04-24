SELECT s.id, s.username, SUM(sk.total_questions_asked) AS Grand_total_questions_asked, COUNT(sk.kanji_id) AS kanji_tracked
    FROM student s
    JOIN student_kanji sk ON s.id = sk.student_id
    GROUP BY s.username
    ORDER BY s.id