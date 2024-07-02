CREATE TABLE temporary_location(
  reference varchar(50),
  date_debut varchar(50),
  duree varchar(50),
  email varchar(50)
);


create or replace function import_client()
RETURNS void AS $$
    BEGIN 
    insert into client(
        email
    )
    select 
        email
        
    from temporary_location
    group by 
        email ON CONFLICT (email) DO NOTHING;
    END;
$$ language plpgsql;

create or replace function import_location()
RETURNS void AS $$
    BEGIN 
    insert into location(
        reference,
        duree,
        date_debut,
        email,
        comission,
        loyer

    )
    select 
       tl.reference,
       tl.duree::double precision,
        to_date(tl.date_debut,'dd/mm/yyyy'),
       tl.email,
       tb.comission,
       b.loyer

    from temporary_location tl
    join bien b on tl.reference=b.reference
    join type_bien tb on b.id_type_bien=tb.id_type_bien 
   join client cl on tl.email=cl.email;
   
      

    END;
$$ language plpgsql;


CREATE OR REPLACE FUNCTION update_location_date_fin()
RETURNS void AS $$
BEGIN
    UPDATE location
    SET date_fin = (
        date_trunc('month', (date_debut - interval '1 month') + interval '1 month' * duree) + interval '1 month' - interval '1 day'
    )
    WHERE duree >= 1;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION insert_into_location_mois()
RETURNS void AS $$
DECLARE
    v_mois_debut DATE;
BEGIN
    INSERT INTO location_mois (id_location, mois, paye, numero_proprio, email_client, numero_comission, loyer, comission)
    SELECT
        loc.id_location,
        DATE_TRUNC('month', monthly_date)::DATE AS mois_debut,
        CASE
            WHEN CURRENT_DATE < DATE_TRUNC('month', monthly_date)::DATE THEN 0
            ELSE 1
        END AS paye,
        prop.numero AS numero_proprio,
        cli.email AS email_client,
        ROW_NUMBER() OVER (PARTITION BY loc.id_location ORDER BY monthly_date) AS numero_comission,
        b.loyer,
        tb.comission
    FROM
        location loc
        JOIN bien b ON loc.reference = b.reference
        JOIN type_bien tb ON b.id_type_bien = tb.id_type_bien
        JOIN proprio prop ON b.numero = prop.numero
        JOIN client cli ON loc.email = cli.email
        CROSS JOIN generate_series(loc.date_debut, loc.date_fin, interval '1 month') AS monthly_date;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION insert_into_location_mois_where(p_id_location int)
RETURNS void AS $$
DECLARE
    v_mois_debut DATE;
BEGIN
    INSERT INTO location_mois (id_location, mois, paye, numero_proprio, email_client, numero_comission, loyer, comission)
    SELECT
        loc.id_location,
        DATE_TRUNC('month', monthly_date)::DATE AS mois_debut,
        CASE
            WHEN CURRENT_DATE < DATE_TRUNC('month', monthly_date)::DATE THEN 0
            ELSE 1
        END AS paye,
        prop.numero AS numero_proprio,
        cli.email AS email_client,
        ROW_NUMBER() OVER (PARTITION BY loc.id_location ORDER BY monthly_date) AS numero_comission,
        b.loyer,
        tb.comission
    FROM
        location loc
        JOIN bien b ON loc.reference = b.reference
        JOIN type_bien tb ON b.id_type_bien = tb.id_type_bien
        JOIN proprio prop ON b.numero = prop.numero
        JOIN client cli ON loc.email = cli.email
        CROSS JOIN generate_series(loc.date_debut, loc.date_fin, interval '1 month') AS monthly_date
    WHERE
        loc.id_location = p_id_location;  -- Filtre par l'id_location passé en paramètre
END;
$$ LANGUAGE plpgsql;


DROP FUNCTION IF EXISTS disponibilite(VARCHAR(50));
CREATE OR REPLACE FUNCTION disponibilite(id_bien VARCHAR(50))
RETURNS TABLE (
    mois_plus_un DATE
) AS $$
BEGIN
    RETURN QUERY
    SELECT
        (date_fin + INTERVAL '1 day')::DATE AS mois_plus_un
    FROM location
    WHERE reference = id_bien
    ORDER by date_fin DESC limit 1;
END;
$$ LANGUAGE plpgsql;
SELECT * FROM disponibilite('V110');


-- Fonction principale pour l'importation
CREATE OR REPLACE FUNCTION import_loca()
RETURNS void AS $$
BEGIN
    PERFORM import_client();
    PERFORM import_location();
    PERFORM update_location_date_fin();
    PERFORM insert_into_location_mois();
END;
$$ LANGUAGE plpgsql;




