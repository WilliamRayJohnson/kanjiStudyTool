CREATE PROCEDURE `add_source` (IN source_name VARCHAR(40))
BEGIN
	INSERT INTO `kanji_source` (`id`, `source`)
		VALUES (NULL, source_name);
END
