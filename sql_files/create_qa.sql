SHOW DATABASES;

DROP DATABASE IF EXISTS qa;
CREATE DATABASE lotrsunx;

SHOW DATABASES;

ALTER DATABASE lotrsunx CHARACTER SET utf8 COLLATE utf8_general_ci;

USE lotrsunx;

DROP TABLE IF EXISTS lotr_species, lotr_books, lotr_regions;
DROP TABLE IF EXISTS lotr_characters;
DROP TABLE IF EXISTS lotr_firstencounters;

SHOW TABLES;

CREATE TABLE qa_users (
	user_id		INT UNSIGNED	NOT NULL	AUTO_INCREMENT,
	username	VARCHAR(32)   	NOT NULL,
	password	VARCHAR(64)
    email       VARCHAR(32)			NULL,
    phone
    is_active   TINYINT     active or not or ban for unrealateed saying
    reg_time    INT  register time
    user_pic    VARCHAR(128) avator
	size			INT UNSIGNED	NOT NULL,
	PRIMARY KEY (user_id),
	UNIQUE INDEX (name)
);
DESCRIBE lotr_species;


CREATE TABLE qa_questions (
	question_id		INT UNSIGNED	NOT NULL	AUTO_INCREMENT,
    title  VARCHAR(128) question title
    desc   TEXT
    cat_id  INT  category of questions
	topic_id INT  topics belong of this questions
    user_id  INT who ask this question
    pub_time    public time
    focus_num  INT
    reply_num   INT
    view_num    INT
);
DESCRIBE lotr_books;


CREATE TABLE qa_categories (
	cat_id		INT UNSIGNED	NOT NULL	AUTO_INCREMENT,
    name  VARCHAR(32),
    logo  VARCHAR(128)   TEXT,
    desc VARCHAR(32),
      parent_id INT
);

CREATE TABLE qa_topics (
	topic_id		INT UNSIGNED	NOT NULL	AUTO_INCREMENT,
	title  VARCHAR(128),
	desc TEXT,
	picture VARCHAR(128)
	logo  VARCHAR(128)   TEXT,
	desc VARCHAR(32),
	parent_id INT
);

CREATE TABLE qa_questions_topics (
	qt_id		INT UNSIGNED	NOT NULL	AUTO_INCREMENT,
	question_id, INT,
	topic_id INT,
	picture VARCHAR(128)
	 logo  VARCHAR(128)   TEXT,
	desc VARCHAR(32),
  parent_id INT
);



CREATE TABLE lotr_regions (
	regions_id				INT UNSIGNED	NOT NULL	AUTO_INCREMENT,
	name					VARCHAR(64)		NOT NULL,
	major_species			VARCHAR(64)		NOT NULL,
	description				TEXT			NULL,
	middle_earth_location	VARCHAR(128)	NOT NULL	DEFAULT '',
	leader					VARCHAR(64)		NOT NULL	DEFAULT 'none',
	PRIMARY KEY (regions_id),
	FOREIGN KEY (major_species) REFERENCES lotr_species (name)
		ON DELETE RESTRICT ON UPDATE CASCADE,
	UNIQUE INDEX (name)
);
DESCRIBE lotr_regions;





CREATE TABLE lotr_characters (
	characters_id				INT UNSIGNED		NOT NULL	AUTO_INCREMENT,
	name						VARCHAR(64)			NOT NULL,
	species						VARCHAR(64)			NOT NULL,
	homeland					VARCHAR(64)			NOT NULL,
	royalty						BOOLEAN				NOT NULL,
	fellowship					BOOLEAN				NOT NULL,
	survive						BOOLEAN				NOT NULL,
	alias						VARCHAR(256)		NOT NULL	DEFAULT '',
	book_number_introduction 	TINYINT UNSIGNED	NOT NULL,
	PRIMARY KEY (characters_id),
	FOREIGN KEY (species) 					REFERENCES lotr_species (name)
		ON DELETE RESTRICT 	ON UPDATE CASCADE,
	FOREIGN KEY (homeland) 					REFERENCES lotr_regions (name)
		ON DELETE RESTRICT 	ON UPDATE CASCADE,
	FOREIGN KEY (book_number_introduction)	REFERENCES lotr_books (number)
		ON DELETE RESTRICT	ON UPDATE RESTRICT,
	UNIQUE INDEX (name)
);
DESCRIBE lotr_characters;


CREATE TABLE lotr_firstencounters (
	firstencounters_id	INT UNSIGNED		NOT NULL	AUTO_INCREMENT,
	character1			VARCHAR(64)			NOT NULL,
	character2			VARCHAR(64)			NOT NULL,
	book				TINYINT UNSIGNED	NOT NULL,
	location     		VARCHAR(64)			NOT NULL,
	PRIMARY KEY (firstencounters_id),
	FOREIGN KEY (character1)	REFERENCES lotr_characters (name)
		ON DELETE CASCADE	ON UPDATE CASCADE,
	FOREIGN KEY (character2)	REFERENCES lotr_characters (name)
		ON DELETE CASCADE	ON UPDATE CASCADE,
	FOREIGN KEY (book) 			REFERENCES lotr_books (number)
		ON DELETE RESTRICT 	ON UPDATE RESTRICT,
	FOREIGN KEY (location) 		REFERENCES lotr_regions (name)
		ON DELETE RESTRICT 	ON UPDATE CASCADE
);
DESCRIBE lotr_firstencounters;


SHOW TABLES;
