DROP DATABASE IF EXISTS familyhub;
CREATE DATABASE familyhub;

USE familyhub;

CREATE TABLE users
(
	id INT NOT NULL AUTO_INCREMENT
	, username VARCHAR(100) NOT NULL
	, email VARCHAR(100) UNIQUE NOT NULL
    , hash VARCHAR(100) NOT NULL
	, PRIMARY KEY (id)
)
ENGINE=InnoDB;

CREATE TABLE families
(
	id INT NOT NULL AUTO_INCREMENT
	, code VARCHAR(100) NOT NULL
	, name VARCHAR(100) NOT NULL
	, PRIMARY KEY (id)
	, UNIQUE (code)
)
ENGINE=InnoDB;

CREATE TABLE users_families
(
	user_id INT NOT NULL
	, family_id INT NOT NULL
	, PRIMARY KEY (user_id, family_id)
	, FOREIGN KEY (user_id) REFERENCES users(id)
	, FOREIGN KEY (family_id) REFERENCES families(id)
)
ENGINE=InnoDB;

CREATE TABLE shopping_lists
(
	id INT NOT NULL AUTO_INCREMENT
	, family_id INT NOT NULL
	, PRIMARY KEY (id)
	, FOREIGN KEY (family_id) REFERENCES families(id)
)
ENGINE=InnoDB;

CREATE TABLE shopping_list_items
(
	id INT NOT NULL AUTO_INCREMENT
	, shopping_list_id INT NOT NULL
	, name VARCHAR(100) NOT NULL
	, is_checked BOOLEAN NOT NULL
	, PRIMARY KEY (id)
	, FOREIGN KEY (shopping_list_id) REFERENCES shopping_lists(id)
)
ENGINE=InnoDB;