PROCEDURE `create_student`(IN student_name VARCHAR(30))
BEGIN
	INSERT INTO `student` (`id`, `name`, `creation_date`, `last_login`)
		VALUE (NULL, student_name, NOW(), NOW());
END