INSERT INTO location_mois (id_location, mois, paye, numero_proprio, email_client)
SELECT
    loc.id_location,
    DATE_TRUNC('month', generate_series(loc.date_debut, loc.date_fin, interval '1 month')) AS mois,
    0 AS paye,  -- Initialiser à non payé
    prop.numero AS numero_proprio,
    cli.email AS email_client
FROM
    location loc
    JOIN bien b ON loc.id_bien = b.id_bien
    JOIN proprio prop ON b.numero = prop.numero
    JOIN client cli ON loc.email = cli.email;