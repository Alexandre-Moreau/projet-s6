DROP TABLE IF EXISTS terme;
DROP TABLE IF EXISTS reference;
DROP TABLE IF EXISTS article;
DROP TABLE IF EXISTS langue;
DROP TABLE IF EXISTS concept;
DROP TABLE IF EXISTS concepPere;
DROP TABLE IF EXISTS relation;

CREATE TABLE article (
	id int AUTO_INCREMENT,
	nom varchar(25) DEFAULT '',
	chemin varchar(75) DEFAULT '',
	type varchar(30) DEFAULT '',
	CONSTRAINT pk_article_id PRIMARY KEY (id)
);

CREATE TABLE langue (
	id int AUTO_INCREMENT,
	nom varchar(30) DEFAULT '',
	CONSTRAINT pk_langue_id PRIMARY KEY (id)
);

CREATE TABLE concept (
	id int AUTO_INCREMENT,
	nom varchar(30) DEFAULT '',
	CONSTRAINT pk_concept_id PRIMARY KEY (id)
);

CREATE TABLE terme (
	id int AUTO_INCREMENT,
	motCle varchar(30) DEFAULT '',
	langue_id int NOT NULL,
	concept_id int NOT NULL,
	CONSTRAINT pk_terme_id PRIMARY KEY (id)
);

CREATE TABLE reference (
	id int AUTO_INCREMENT,
	nombreRef int DEFAULT 1,
	article_id int NOT NULL,
	concept_id int NOT NULL,
	CONSTRAINT pk_reference_id PRIMARY KEY (id)
);

CREATE TABLE relation (
	type varchar(15) DEFAULT 'isA',
	conceptFrom_id int NOT NULL,
	conceptTo_id int NOT NULL
);

ALTER TABLE terme
ADD CONSTRAINT fk_terme_langue_id FOREIGN KEY (langue_id) REFERENCES langue(id),
ADD CONSTRAINT fk_terme_concept_id FOREIGN KEY (concept_id) REFERENCES concept(id);

ALTER TABLE reference
ADD CONSTRAINT fk_reference_article_id FOREIGN KEY (article_id) REFERENCES article(id),
ADD CONSTRAINT fk_reference_concept_id FOREIGN KEY (concept_id) REFERENCES concept(id);

ALTER TABLE relation
ADD CONSTRAINT fk_relation_conceptFrom_id FOREIGN KEY (conceptFrom_id) REFERENCES concept(id),
ADD CONSTRAINT fk_relation_conceptFroms_id FOREIGN KEY (conceptTo_id) REFERENCES concept(id);
