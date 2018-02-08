/* Concepts racine */
SELECT *
FROM concept
WHERE concept.id NOT IN(
	SELECt conceptFrom_id
	FROM relation
	WHERE type="isA"
)