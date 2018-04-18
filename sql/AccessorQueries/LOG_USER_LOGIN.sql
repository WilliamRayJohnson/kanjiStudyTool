UPDATE student
    SET last_login = NOW()
    WHERE username = ?