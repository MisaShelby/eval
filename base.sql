Create DATABASE evaluation;
\c evaluation;

CREATE TABLE login (
    id_login SERIAL PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    login VARCHAR(50) NOT NULL UNIQUE,
    pwd VARCHAR(50) NOT NULL
);

CREATE TABLE types(
    id_type SERIAL PRIMARY KEY,
    nom varchar(50)
);

CREATE TABLE proprio( 
    numero varchar(50) PRIMARY KEY,
    id_type int REFERENCES types (id_type)
);

CREATE TABLE client(
    email varchar(50) PRIMARY KEY,
    id_type int REFERENCES types (id_type)
);

CREATE TABLE type_bien( 
    id_type_bien SERIAL PRIMARY KEY,
    nom_bien varchar(50),
    comission double precision
);

CREATE TABLE bien(
    reference varchar(50) PRIMARY KEY,
    description TEXT,
    region varchar(50),
    loyer double precision,
    numero varchar(50) REFERENCES proprio (numero),
    nom varchar(50),
    actif int default 0,
    id_type_bien int REFERENCES type_bien (id_type_bien)
);

CREATE TABLE bien_photo(
    id_photo SERIAL PRIMARY KEY,
    reference varchar(50) REFERENCES bien (reference),
    nom varchar(50)
);

CREATE TABLE location (
    id_location SERIAL PRIMARY KEY,
    duree double precision,
    date_debut date,
    date_fin date,
    comission double precision,
    loyer double precision,
    reference varchar(50) REFERENCES bien (reference),
    email varchar(50) REFERENCES client (email)
);



INSERT INTO login (nom, login, pwd) VALUES
('Equipe A', 'admin', '1111'),
('Equipe B', 'user', '0000');


INSERT INTO types (nom) VALUES ('Particulier');
INSERT INTO types (nom) VALUES ('Professionnel');

-- Insert test data into proprio table
INSERT INTO proprio (numero, id_type) VALUES ('0340513100', 1);
INSERT INTO proprio (numero, id_type) VALUES ('12345', 2);

-- Insert test data into client table
INSERT INTO client (email, id_type) VALUES ('pri@gmail.com', 1);
INSERT INTO client (email, id_type) VALUES ('bekzi@gmail.com', 2);

-- Insert test data into type_bien table
INSERT INTO type_bien (nom, comission) VALUES ('Apartment', 5.5);
INSERT INTO type_bien (nom, comission) VALUES ('House', 6.0);
INSERT INTO type_bien (nom, comission) VALUES ('Villa', 7.0);

-- Insert test data into bien table
INSERT INTO bien (description, region, loyer, numero, nom, id_type_bien) VALUES 
('Beautiful apartment in downtown', 'City Center', 1200.0, '0340513100', 'Downtown Apartment', 1),
('Tsara be!!!!!', 'Antananarivo', 800.0, '0340513100', 'Trano kely', 2),
('Doraintss be!!!', 'Ambanidia', 2200.0, '0340513100', 'Villa be', 3),
('Tsy de manahona firy', 'Tanjombato', 500.0, '12345', 'Tsano', 2),
('Spacious house with garden', 'Suburbs', 2500.0, '12345', 'Garden House', 2),
('Ayeee!!!!', 'Paraky', 1500.0, '12345', 'Extrapizza', 3);

INSERT INTO location (duree, date_debut, date_fin, comission, loyer, reference, email) VALUES 
(12, '2023-01-12', '2023-12-31', 5.5, 1200.0, 1, 'pri@gmail.com'),
(7, '2023-06-01', '2023-12-01', 6.0, 2500.0, 2, 'bekzi@gmail.com'),
(24, '2024-06-01', '2025-12-01', 7.0, 3500.0, 3, 'bekzi@gmail.com'),
(48, '2018-02-18', '2020-03-31', 10, 1200.0, 5, 'pri@gmail.com');

/*
CREATE OR REPLACE VIEW chiffre_affaires_mensuel AS
SELECT
    DATE_TRUNC('month', generate_series(location.date_debut, location.date_fin, interval '1 month')) AS mois,
    SUM(location.loyer) AS total_loyer,
    SUM(location.loyer * (location.comission / 100)) AS total_comission,
    proprio.numero AS numero_proprio,
    client.email AS email_client
FROM
    location
    JOIN bien ON location.reference = bien.reference
    JOIN proprio ON bien.numero = proprio.numero
    JOIN client ON location.email = client.email
GROUP BY
    DATE_TRUNC('month', generate_series(location.date_debut, location.date_fin, interval '1 month')),
    numero_proprio, email_client
ORDER BY
    mois;
*/

CREATE TABLE location_mois (
    id_location_mois SERIAL PRIMARY KEY,
    id_location INT REFERENCES location(id_location),
    mois DATE,
    paye INT DEFAULT 0,  -- 0 pour non payé, 1 pour payé
    numero_proprio VARCHAR(50),
    email_client VARCHAR(50),
    numero_comission INT,
    loyer DOUBLE PRECISION,
    comission DOUBLE PRECISION
);






-------View manao chiffre affaire rehetra 
DROP VIEW IF EXISTS chiffre_affaires_mensuel;
CREATE OR REPLACE VIEW chiffre_affaires_mensuel AS
WITH location_mois_stats AS (
    SELECT
        lm.id_location,
        lm.mois AS mois,
        MAX(lm.paye) AS paye
    FROM
        location_mois lm
    GROUP BY
        lm.id_location,
        lm.mois
)
SELECT
    l.id_location,
    lm.mois AS mois,
    SUM(lm.loyer) AS total_loyer,
    SUM(lm.loyer * (lm.comission / 100)) AS total_comission,
    p.numero AS numero_proprio,
    c.email AS email_client,
    COALESCE(lms.paye, 0) AS paye
FROM
    location_mois_stats lms
JOIN location l ON lms.id_location = l.id_location
LEFT JOIN location_mois lm ON l.id_location = lm.id_location AND DATE_TRUNC('month', lm.mois) = DATE_TRUNC('month', lms.mois)
JOIN client c ON lm.email_client = c.email
JOIN proprio p ON lm.numero_proprio = p.numero
GROUP BY
    l.id_location,
    lm.mois,
    p.numero,
    c.email,
    lms.paye
ORDER BY
    mois;

    ---------
CREATE OR REPLACE FUNCTION update_paye_status()
RETURNS void AS $$
DECLARE
    integer_var INTEGER;
BEGIN
    RAISE NOTICE 'Updating paye status...';
    
    -- Met à jour la colonne paye dans location_mois en utilisant les valeurs de chiffre_affaires_mensuel jusqu'à la date actuelle
    UPDATE location_mois lm
    SET paye = cam.paye
    FROM (
        SELECT *
        FROM chiffre_affaires_mensuel
        WHERE mois <= CURRENT_DATE
    ) cam
    WHERE lm.id_location = cam.id_location
    AND lm.mois = cam.mois;
    
    GET DIAGNOSTICS integer_var = ROW_COUNT;
    RAISE NOTICE 'Rows affected: %', integer_var;
    
    RAISE NOTICE 'Update completed.';
END;
$$ LANGUAGE plpgsql;
-----------------------------mise a jour ligne anakiray---------------------
--UPDATE location_mois
--SET paye = 1
--WHERE id_location = 1 AND DATE_TRUNC('month', mois) = '2024-06-01';
--SELECT * FROM location_mois WHERE DATE_TRUNC('month', mois) = '2024-06-01';


