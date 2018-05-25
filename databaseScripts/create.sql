DROP TABLE IF EXISTS relation;
DROP TABLE IF EXISTS reference;
DROP TABLE IF EXISTS terme;
DROP TABLE IF EXISTS article;
DROP TABLE IF EXISTS langue;
DROP TABLE IF EXISTS concept;

CREATE TABLE article (
	id int AUTO_INCREMENT,
	nom varchar(25) DEFAULT '',
	chemin varchar(75) DEFAULT '' UNIQUE,
	type varchar(30) DEFAULT '',
	nbMots int DEFAULT -1,
	langue_id int NOT NULL,
	CONSTRAINT pk_article_id PRIMARY KEY (id)
);

CREATE TABLE langue (
	id int AUTO_INCREMENT,
	nom varchar(30) DEFAULT '' UNIQUE,
	CONSTRAINT pk_langue_id PRIMARY KEY (id)
);

CREATE TABLE concept (
	id int AUTO_INCREMENT,
	nom varchar(200) DEFAULT '',
	CONSTRAINT pk_concept_id PRIMARY KEY (id)
);

CREATE TABLE terme (
	id int AUTO_INCREMENT,
	motCle varchar(30) DEFAULT '',
	langue_id int NOT NULL,
	concept_id int NOT NULL,
	prefered TINYINT(1) DEFAULT 1,
	CONSTRAINT pk_terme_id PRIMARY KEY (id)
);

CREATE TABLE reference (
	id int AUTO_INCREMENT,
	position int DEFAULT -1,
	nombreMot int DEFAULT 1,
	contexte varchar(200) DEFAULT '',
	article_id int NOT NULL,
	concept_id int NOT NULL,
	CONSTRAINT pk_reference_id PRIMARY KEY (id)
);

CREATE TABLE relation (
	id int AUTO_INCREMENT,
	type varchar(15) DEFAULT 'isA',
	conceptFrom_id int NOT NULL,
	conceptTo_id int NOT NULL,
	CONSTRAINT pk_relation_id PRIMARY KEY (id)
);

ALTER TABLE article
ADD CONSTRAINT fk_article_langue_id FOREIGN KEY (langue_id) REFERENCES langue(id) ON DELETE CASCADE;

ALTER TABLE terme
ADD CONSTRAINT fk_terme_langue_id FOREIGN KEY (langue_id) REFERENCES langue(id) ON DELETE CASCADE,
ADD CONSTRAINT fk_terme_concept_id FOREIGN KEY (concept_id) REFERENCES concept(id) ON DELETE CASCADE;

ALTER TABLE reference
ADD CONSTRAINT fk_reference_article_id FOREIGN KEY (article_id) REFERENCES article(id) ON DELETE CASCADE,
ADD CONSTRAINT fk_reference_concept_id FOREIGN KEY (concept_id) REFERENCES concept(id) ON DELETE CASCADE;

ALTER TABLE relation
ADD CONSTRAINT fk_relation_conceptFrom_id FOREIGN KEY (conceptFrom_id) REFERENCES concept(id) ON DELETE CASCADE,
ADD CONSTRAINT fk_relation_conceptFroms_id FOREIGN KEY (conceptTo_id) REFERENCES concept(id) ON DELETE CASCADE;
