PROCEDURE `add_kanji`(IN kanji VARCHAR(1), IN source_id INT)
BEGIN
	INSERT INTO `kanji` (`id`, `kanji`, `source_id`)
		VALUES (NULL, kanji, source_id);
END