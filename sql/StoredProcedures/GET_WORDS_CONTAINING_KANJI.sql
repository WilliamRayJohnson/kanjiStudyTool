PROCEDURE `get_words_containing_kanji`(IN kanji_word_id INT)
BEGIN
	SELECT word, reading
    FROM kanji_in_word KiW, word w
    WHERE KiW.kanji_id = kanji_word_id AND KiW.word_id = w.id;
END