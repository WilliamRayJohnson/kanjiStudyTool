CREATE PROCEDURE `GET_QUIZ_ANSWERS` (IN quizKanji VARCHAR(1), IN quizWord VARCHAR(10), IN answerCount INT)
BEGIN
    SELECT w.word, w.reading
        FROM word w
        JOIN kanji_in_word kiw ON kiw.word_id = w.id
        JOIN kanji k ON k.id = kiw.kanji_id
        WHERE k.kanji = quizKanji AND NOT w.word = quizWord
    UNION
    SELECT w.word, w.reading
        FROM word w
        JOIN kanji_in_word kiw ON kiw.word_id = w.id
        JOIN kanji k ON k.id = kiw.kanji_id
        WHERE k.source_id = (SELECT source_id FROM kanji WHERE kanji=quizKanji) AND NOT w.word = quizWord
    ORDER BY RAND()
    LIMIT answerCount;
END