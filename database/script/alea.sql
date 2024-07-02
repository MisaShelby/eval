-----raha ohatra ka fois 2 ilay loyer 1er mois
UPDATE location_mois 
SET loyer = loyer * 2, comission = 50 
WHERE numero_comission = 1;
--------raha ohatra ka +10% ny loyer manomboka juillet 07
UPDATE location_mois
SET loyer = loyer + (loyer * 10 / 100)
WHERE EXTRACT(MONTH FROM mois) >= 7;

-------------raha ohatra ka 0 comission
UPDATE location_mois
SET comission=0
WHERE numero_comission >= 3;

--------raha ohatra ka 1er lois du mois d'un bien de mila mjoin an'ilay id_bien=reference  @ilay location_mois
UPDATE location_mois lm
SET 
    lm.loyer = lm.loyer * 2,
    lm.comission = lm.comission
FROM 
    location l
WHERE 
    lm.id_location = l.id_location
    AND l.reference = 'votre_reference';
