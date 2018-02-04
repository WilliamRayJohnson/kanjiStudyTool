PROCEDURE `add_word`(IN word VARCHAR(10), IN reading VARCHAR(20))
BEGIN
	INSERT INTO `word` (`id`, `word`, `reading`)
		VALUE (NULL, word, reading);
END