CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectSede`(IN `_id` INT)
BEGIN
    SELECT 
    sede.sede_id, 
    sede.sede_razonsocial, 
    sede.sede_empleados, 
    sede.sede_telefono, 
    sede.sede_movil, 
    sede.sede_fax, 
    sede.sede_sitioweb, 
    sede.sede_descripcion,
    sede.sede_direccion, 
    sede.sede_codigopostal, 
    sede.sede_administrador, 
    sede.sede_fechamodificacion, 
    sede.sede_fecharegistro, 
    sede.sede_usu_id, 
    sede.ciudad_ciu_id,
    sede.pais_pai_id, 
    sede.sede_correo_principal, 
    sede.sede_correo_secundario, 
    sede.sede_estado ,
    ciudad.ciu_nombre,
    ciudad.ciu_id,
    estado.est_id,
    estado.est_nombre,
    pais.pai_id,
    pais.pai_nombre,
    pais.pai_prefijo,
    (SELECT  concat(persona.per_nombre, ' ' , persona.per_apellido) as 'nombre' FROM `usuario`, persona WHERE usuario.usu_id= sede.sede_usu_id and usuario.Persona_per_id = persona.per_id) as 'modificador'
    FROM sede, pais, estado, ciudad
    WHERE 
    sede.sede_id= _id and
    sede.ciudad_ciu_id = ciudad.ciu_id and 
    estado.est_id = ciudad.estado_est_id and
    sede.pais_pai_id = pais.pai_id  and 
    BINARY sede.sede_estado = 'A';

END;
