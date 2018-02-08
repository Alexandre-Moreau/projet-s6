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


/* Relations DEFAULT = "isA" */
INSERT INTO relation VALUES (DEFAULT, (SELECT id FROM concept WHERE nom='Vehicule à roues'), (SELECT id FROM concept WHERE nom='Vehicule'));
INSERT INTO relation VALUES (DEFAULT, (SELECT id FROM concept WHERE nom='Voiture'), (SELECT id FROM concept WHERE nom='Vehicule à roues'));
INSERT INTO relation VALUES (DEFAULT, (SELECT id FROM concept WHERE nom='Camping Car'), (SELECT id FROM concept WHERE nom='Vehicule à roues'));
INSERT INTO relation VALUES (DEFAULT, (SELECT id FROM concept WHERE nom='Camping Car'), (SELECT id FROM concept WHERE nom='Habitation'));
INSERT INTO relation VALUES (DEFAULT, (SELECT id FROM concept WHERE nom='Maison'), (SELECT id FROM concept WHERE nom='Habitation'));
INSERT INTO relation VALUES (DEFAULT, (SELECT id FROM concept WHERE nom='Immeuble'), (SELECT id FROM concept WHERE nom='Habitation'));


















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
