\c evaluation;
CREATE TABLE teboka(
    classement varchar(30),
    points varchar(30)
);

create or replace function import_point()
RETURNS void AS $$
    BEGIN 
    insert into classement(
       rang,
       points
    )
    select 
        classement::integer,
        points::integer
    from teboka
    group by 
        classement,
        points;
    END;
$$ language plpgsql;




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
