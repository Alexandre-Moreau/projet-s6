/* Langues fr/en/cn */
INSERT INTO `langue`(`id`, `nom`) VALUES (DEFAULT, 'fr');
INSERT INTO `langue`(`id`, `nom`) VALUES (DEFAULT, 'en');
INSERT INTO `langue`(`id`, `nom`) VALUES (DEFAULT, 'cn');

/* Concepts */
INSERT INTO `concept`(`id`, `nom`) VALUES (DEFAULT, 'Siege');
INSERT INTO `concept`(`id`, `nom`) VALUES (DEFAULT, 'Siege sans bras');

/* Termes */
INSERT INTO `terme`(`id`, `motCle`, `langue_id`, `concept_id`) VALUES (DEFAULT, 'siege', '1', '1');
INSERT INTO `terme`(`id`, `motCle`, `langue_id`, `concept_id`) VALUES (DEFAULT, 'seat', '2', '1');
INSERT INTO `terme`(`id`, `motCle`, `langue_id`, `concept_id`) VALUES (DEFAULT, '椅子', '3', '1');

INSERT INTO `terme`(`id`, `motCle`, `langue_id`, `concept_id`) VALUES (DEFAULT, 'banc', '1', '2');
INSERT INTO `terme`(`id`, `motCle`, `langue_id`, `concept_id`) VALUES (DEFAULT, 'bench', '2', '2');
INSERT INTO `terme`(`id`, `motCle`, `langue_id`, `concept_id`) VALUES (DEFAULT, '长凳', '3', '2');