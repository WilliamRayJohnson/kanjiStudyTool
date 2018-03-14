PROCEDURE `GET_KANJI_STATS`(IN quizKanji VARCHAR(1), IN username VARCHAR(30))
BEGIN
	SELECT sk.retention_score, sk.correct_response_count, sk.incorrect_response_count
	FROM student_kanji sk
	JOIN student s ON s.id = sk.student_id
	JOIN kanji k ON k.id = sk.kanji_id
	WHERE k.kanji = quizKanji AND s.name = username;
END