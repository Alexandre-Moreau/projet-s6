SELECT langue.nom, terme.motCle, concept.nom 
FROM `terme`, `concept`, `langue` 
WHERE concept_id = concept.id AND langue_id = langue.id
ORDER BY langue_id