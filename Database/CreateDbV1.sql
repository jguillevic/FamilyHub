DROP DATABASE IF EXISTS familyhub;
CREATE DATABASE familyhub;

USE familyhub;

CREATE TABLE user
(
	id INT NOT NULL AUTO_INCREMENT
	, username VARCHAR(35) NOT NULL
	, password VARCHAR(100) NOT NULL
	, PRIMARY KEY (id)
)
ENGINE=InnoDB;