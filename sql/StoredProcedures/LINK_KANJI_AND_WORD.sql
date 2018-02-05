CREATE PROCEDURE `link_kanji_and_word` (IN kanji_id INT, IN word_id INT)
BEGIN
	INSERT INTO `kanji_in_word` (`id`, `word_id`, `kanji_id`)
		VALUE (NULL, word_id, kanji_id);
END