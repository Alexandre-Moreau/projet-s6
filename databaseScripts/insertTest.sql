/* Langues fr/en/cn */
INSERT INTO langue VALUES (DEFAULT, 'fr');
INSERT INTO langue VALUES (DEFAULT, 'en');
INSERT INTO langue VALUES (DEFAULT, 'cn');

/* Concepts */
INSERT INTO concept VALUES (DEFAULT, 'Vehicule');
INSERT INTO concept VALUES (DEFAULT, 'Vehicule à roues');
INSERT INTO concept VALUES (DEFAULT, 'Habitation');
INSERT INTO concept VALUES (DEFAULT, 'Voiture');
INSERT INTO concept VALUES (DEFAULT, 'Camping Car');
INSERT INTO concept VALUES (DEFAULT, 'Maison');
INSERT INTO concept VALUES (DEFAULT, 'Immeuble');

/* Relations (DEFAULT = "isA") */
INSERT INTO relation VALUES (DEFAULT, DEFAULT, (SELECT id FROM concept WHERE nom='Vehicule à roues'), (SELECT id FROM concept WHERE nom='Vehicule'));
INSERT INTO relation VALUES (DEFAULT, DEFAULT, (SELECT id FROM concept WHERE nom='Voiture'), (SELECT id FROM concept WHERE nom='Vehicule à roues'));
INSERT INTO relation VALUES (DEFAULT, DEFAULT, (SELECT id FROM concept WHERE nom='Camping Car'), (SELECT id FROM concept WHERE nom='Vehicule à roues'));
INSERT INTO relation VALUES (DEFAULT, DEFAULT, (SELECT id FROM concept WHERE nom='Camping Car'), (SELECT id FROM concept WHERE nom='Habitation'));
INSERT INTO relation VALUES (DEFAULT, DEFAULT, (SELECT id FROM concept WHERE nom='Maison'), (SELECT id FROM concept WHERE nom='Habitation'));
INSERT INTO relation VALUES (DEFAULT, DEFAULT, (SELECT id FROM concept WHERE nom='Immeuble'), (SELECT id FROM concept WHERE nom='Habitation'));

/* Termes */
INSERT INTO terme VALUES(DEFAULT, 'véhicule', (SELECT id FROM langue WHERE nom='fr'), (SELECT id FROM concept WHERE nom='Vehicule'));
INSERT INTO terme VALUES(DEFAULT, 'véhicules', (SELECT id FROM langue WHERE nom='fr'), (SELECT id FROM concept WHERE nom='Vehicule'));
INSERT INTO terme VALUES(DEFAULT, 'vehicule', (SELECT id FROM langue WHERE nom='fr'), (SELECT id FROM concept WHERE nom='Vehicule'));
INSERT INTO terme VALUES(DEFAULT, 'vehicules', (SELECT id FROM langue WHERE nom='fr'), (SELECT id FROM concept WHERE nom='Vehicule'));
INSERT INTO terme VALUES(DEFAULT, 'vehicle', (SELECT id FROM langue WHERE nom='en'), (SELECT id FROM concept WHERE nom='Vehicule'));
INSERT INTO terme VALUES(DEFAULT, 'vehicles', (SELECT id FROM langue WHERE nom='en'), (SELECT id FROM concept WHERE nom='Vehicule'));

INSERT INTO terme VALUES(DEFAULT, 'voiture', (SELECT id FROM langue WHERE nom='fr'), (SELECT id FROM concept WHERE nom='Voiture'));
INSERT INTO terme VALUES(DEFAULT, 'voitures', (SELECT id FROM langue WHERE nom='fr'), (SELECT id FROM concept WHERE nom='Voiture'));
INSERT INTO terme VALUES(DEFAULT, 'car', (SELECT id FROM langue WHERE nom='en'), (SELECT id FROM concept WHERE nom='Voiture'));
INSERT INTO terme VALUES(DEFAULT, 'cars', (SELECT id FROM langue WHERE nom='en'), (SELECT id FROM concept WHERE nom='Voiture'));

INSERT INTO terme VALUES(DEFAULT, 'habitation', (SELECT id FROM langue WHERE nom='fr'), (SELECT id FROM concept WHERE nom='Habitation'));
INSERT INTO terme VALUES(DEFAULT, 'habitations', (SELECT id FROM langue WHERE nom='fr'), (SELECT id FROM concept WHERE nom='Habitation'));
INSERT INTO terme VALUES(DEFAULT, 'home', (SELECT id FROM langue WHERE nom='en'), (SELECT id FROM concept WHERE nom='Habitation'));
INSERT INTO terme VALUES(DEFAULT, 'homes', (SELECT id FROM langue WHERE nom='en'), (SELECT id FROM concept WHERE nom='Habitation'));

INSERT INTO terme VALUES(DEFAULT, 'maison', (SELECT id FROM langue WHERE nom='fr'), (SELECT id FROM concept WHERE nom='Maison'));
INSERT INTO terme VALUES(DEFAULT, 'maisons', (SELECT id FROM langue WHERE nom='fr'), (SELECT id FROM concept WHERE nom='Maison'));
INSERT INTO terme VALUES(DEFAULT, 'house', (SELECT id FROM langue WHERE nom='en'), (SELECT id FROM concept WHERE nom='Maison'));
INSERT INTO terme VALUES(DEFAULT, 'houses', (SELECT id FROM langue WHERE nom='en'), (SELECT id FROM concept WHERE nom='Maison'));

INSERT INTO terme VALUES(DEFAULT, 'camping car', (SELECT id FROM langue WHERE nom='fr'), (SELECT id FROM concept WHERE nom='Camping car'));
INSERT INTO terme VALUES(DEFAULT, 'camping car', (SELECT id FROM langue WHERE nom='en'), (SELECT id FROM concept WHERE nom='Camping car'));
INSERT INTO terme VALUES(DEFAULT, 'camping cars', (SELECT id FROM langue WHERE nom='en'), (SELECT id FROM concept WHERE nom='Camping car'));

/* Articles */
INSERT INTO article VALUES(DEFAULT, 'maison', 'articles/maison1.pdf', 'pdf', 39);

/* Références */
INSERT INTO reference VALUES(DEFAULT, 2, (SELECT id FROM article WHERE chemin='articles/maison1.pdf'), (SELECT id FROM concept WHERE nom='Habitation'));
INSERT INTO reference VALUES(DEFAULT, 3, (SELECT id FROM article WHERE chemin='articles/maison1.pdf'), (SELECT id FROM concept WHERE nom='Maison'));


/* Termes */

/*
INSERT INTO `terme`(`id`, `motCle`, `langue_id`, `concept_id`) VALUES (DEFAULT, 'camping car', '1', '1');
INSERT INTO `terme`(`id`, `motCle`, `langue_id`, `concept_id`) VALUES (DEFAULT, 'camping car', '2', '1');
INSERT INTO `terme`(`id`, `motCle`, `langue_id`, `concept_id`) VALUES (DEFAULT, 'voiture', '1', '1');
INSERT INTO `terme`(`id`, `motCle`, `langue_id`, `concept_id`) VALUES (DEFAULT, 'car', '2', '1');

INSERT INTO `terme`(`id`, `motCle`, `langue_id`, `concept_id`) VALUES (DEFAULT, 'maison', '1', '2');
INSERT INTO `terme`(`id`, `motCle`, `langue_id`, `concept_id`) VALUES (DEFAULT, 'hause', '1', '2');
INSERT INTO `terme`(`id`, `motCle`, `langue_id`, `concept_id`) VALUES (DEFAULT, 'immeuble', '1', '2');
INSERT INTO `terme`(`id`, `motCle`, `langue_id`, `concept_id`) VALUES (DEFAULT, 'building', '1', '2');
INSERT INTO `terme`(`id`, `motCle`, `langue_id`, `concept_id`) VALUES (DEFAULT, 'camping car', '1', '2');
INSERT INTO `terme`(`id`, `motCle`, `langue_id`, `concept_id`) VALUES (DEFAULT, 'camping car', '2', '2');
*/
