/* Langues fr/en/cn */
INSERT INTO `langue`(`id`, `nom`) VALUES (DEFAULT, 'fr');
INSERT INTO `langue`(`id`, `nom`) VALUES (DEFAULT, 'en');
INSERT INTO `langue`(`id`, `nom`) VALUES (DEFAULT, 'cn');

/* Concepts */
INSERT INTO `concept`(`id`, `nom`) VALUES (DEFAULT, 'Vehicule');
INSERT INTO `concept`(`id`, `nom`) VALUES (DEFAULT, 'Habitation');

/* Concepts Peres */


/* Termes */
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
