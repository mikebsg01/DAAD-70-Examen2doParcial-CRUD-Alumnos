CREATE DATABASE school CHARACTER SET utf8 COLLATE utf8_general_ci;

use school;

CREATE TABLE IF NOT EXISTS school.students (
	id INT NOT NULL AUTO_INCREMENT,
	file_number INT(6) NOT NULL,
	first_name VARCHAR(25) NOT NULL,
    last_name VARCHAR(25) NOT NULL,
    career VARCHAR(45) NOT NULL,
    PRIMARY KEY(id)
);