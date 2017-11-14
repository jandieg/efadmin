CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectPAMAsistente`(IN `_id_miembro` INT, IN `_bandera` INT)
BEGIN

declare _prefijo varchar(50);


         SELECT pais.pai_prefijo into _prefijo FROM direccion , ciudad, estado, pais, miembro
        WHERE 
        miembro.mie_id = _id_miembro and 
        direccion.Persona_per_id=miembro.Persona_per_id and 
        ciudad.ciu_id= direccion.ciudad_ciu_id and 
        ciudad.estado_est_id = estado.est_id and
        pais.pai_id= estado.pais_pai_id limit 1;


if _bandera = '1' then
    SELECT 
    miembro_asistente.mie_asi_id,
    miembro_asistente.miembro_mie_id,
    miembro_asistente.persona_per_id,
    miembro_asistente.cargo_id,
    miembro_asistente.mie_asi_fechamodificacion,
    miembro_asistente.mie_asi_fecharegistro,
    miembro_asistente.mie_asi_usu_id,
    (SELECT  cat_descripcion FROM categoria WHERE cat_id= miembro_asistente.cargo_id ) as 'cargo',
    persona.per_id, 
    persona.per_nombre, 
    persona.per_apellido
    ,(SELECT  cor_descripcion  FROM correo WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo'
    ,(SELECT  concat('(',ifnull(_prefijo,''),') ', tel_descripcion) FROM telefono WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil'
    ,(SELECT  concat('(',ifnull(_prefijo,''),') ', tel_descripcion) FROM telefono WHERE Persona_per_id=persona.per_id and tel_tipo= 'C' LIMIT 1 ) as 'fijo'
    FROM miembro_asistente
    join persona on miembro_asistente.Persona_per_id  = persona.per_id
    WHERE miembro_asistente.miembro_mie_id = _id_miembro;
   
   end if;
   if _bandera = '2' then
    SELECT 
    prospecto_asistente.prosp_asi_id as 'mie_asi_id',
    prospecto_asistente.prospecto_id as 'miembro_mie_id',
    prospecto_asistente.persona_per_id,
    prospecto_asistente.categoria_cat_id as 'cargo_id',
    prospecto_asistente.prosp_asi_fechamodificacion as 'mie_asi_fechamodificacion',
    prospecto_asistente.prosp_asi_fecharegistro as 'mie_asi_fecharegistro',
    prospecto_asistente.prosp_asi_usu_id as 'mie_asi_usu_id',
    (SELECT  cat_descripcion FROM categoria WHERE cat_id= prospecto_asistente.categoria_cat_id ) as 'cargo',
    persona.per_id, 
    persona.per_nombre, 
    persona.per_apellido
    ,(SELECT  cor_descripcion  FROM correo WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo'
    ,(SELECT  tel_descripcion FROM telefono WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil'
    ,(SELECT  tel_descripcion FROM telefono WHERE Persona_per_id=persona.per_id and tel_tipo= 'C' LIMIT 1 ) as 'fijo'
    FROM prospecto_asistente
    join persona on prospecto_asistente.Persona_per_id  = persona.per_id
    WHERE prospecto_asistente.prospecto_id = _id_miembro;
   
   end if;
END;
