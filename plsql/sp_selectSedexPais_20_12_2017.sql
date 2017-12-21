CREATE PROCEDURE `sp_selectSedexPais`(_id int(11))
BEGIN
    select s.sede_id, s.sede_razonsocial, c.ciu_nombre from sede s join ciudad c 
    on s.ciudad_ciu_id = c.ciu_id where s.pais_pai_id = _id; 
END;
