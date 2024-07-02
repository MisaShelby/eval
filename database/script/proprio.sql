\c evaluation;
CREATE TABLE temporary_bien(
   reference varchar(50),
   nom varchar(50),
   description text,
   nom_bien varchar(50),
   region varchar(50),
    loyer varchar(50),
     numero varchar(50)
);

CREATE TABLE temporary_type(
    nom_bien varchar(20),
    comission varchar(20)

);

create or replace function import_type_comission()
RETURNS void AS $$
    BEGIN 
    insert into type_bien(
      nom_bien,
      comission
    )
    select 
       nom_bien,
       comission::double precision
        
    from temporary_type
    group by 
        nom_bien,
        comission;
    END;

$$ language plpgsql;

create or replace function import_proprio()
RETURNS void AS $$
    BEGIN 
    insert into proprio(
      numero
    )
    select 
        numero
        
    from temporary_bien
    group by 
        numero on conflict (numero) do nothing;
    END;
$$ language plpgsql;


create or replace function import_bien()
RETURNS void AS $$
    BEGIN 
    insert into bien(
      reference,
      nom,
      description,
      id_type_bien,
      region,
      loyer,
      numero
    )
    select 
        tb.reference,
        tb.nom,
        tb.description,
        b.id_type_bien::integer,
        tb.region,
        tb.loyer::double precision,
        tb.numero
    from temporary_bien tb
    join proprio p on tb.numero=p.numero
    join type_bien b on tb.nom_bien=b.nom_bien
    group by 
      tb.reference,
      tb.nom,
      tb.description,
      b.id_type_bien,
      tb.region,
      tb.loyer,
      tb.numero
         ON CONFLICT (reference) DO NOTHING;
    END;
$$ language plpgsql;











 create or replace function import_bien()
 RETURNS void AS $$
     BEGIN
     insert into bien(
       reference,
       nom,
       description,
       id_type_bien,
       region,
       loyer,
       numero
     )
     select
         tb.reference,
         tb.nom,
         tb.description,
         b.id_type_bien::integer,
         tb.region,
         tb.loyer::double precision,
         tb.numero
     from temporary_bien tb
     join proprio p on tb.numero=p.numero
     join type_bien b on tb.nom_bien=b.nom_bien
     group by
       tb.reference,
       tb.nom,
       tb.description,
       b.id_type_bien,
       tb.region,
       tb.loyer,
       tb.numero
          ON CONFLICT (reference) DO NOTHING;
     END;
 $$ language plpgsql;





 
create or replace function import_bonne()
RETURNS void AS $$
    BEGIN 
        PERFORM import_proprio();
        PERFORM import_type_comission();
         PERFORM import_bien();
         
    END;
$$ language plpgsql;



-----------
