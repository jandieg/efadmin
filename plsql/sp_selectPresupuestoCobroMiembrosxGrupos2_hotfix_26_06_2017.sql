CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectPresupuestoCobroMiembrosxGrupos2`(IN `_id` INT, IN `_year` INT)
BEGIN
 SELECT
miembro.mie_id,
miembro.grupo_id,
miembro.empresalocal_emp_id,
miembro. mie_fecharegistro,
(SELECT emp_nombre FROM empresalocal WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
persona.per_id ,  
persona.per_nombre, 
persona.per_apellido, 
(SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
         FROM persona, perfil, usuario 
         WHERE usuario.usu_id= miembro.forum_usu_id 
         and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum',
presupuestocobro.precobro_id  ,
presupuestocobro.precobro_fechainiciomiembro,
presupuestocobro.precobro_valor ,
presupuestocobro.periodo_perio_id,
presupuestocobro.precobro_total  ,
presupuestocobro.precobro_year ,
(SELECT  `perio_descripcion` FROM `periodo` WHERE perio_id= presupuestocobro.periodo_perio_id) AS 'precobro_periodo' ,
(SELECT  `detalleprecobro_fechavencimiento` FROM `detallepresupuestocobro` WHERE presupuestocobro_precobro_id= presupuestocobro.precobro_id and estado_presupuesto_est_pre_id= '1' LIMIT 1) AS 'fecha_x_pagar' ,
(SELECT  Max(`detalleprecobro_fechavencimiento`) FROM `detallepresupuestocobro` WHERE presupuestocobro_precobro_id= presupuestocobro.precobro_id and estado_presupuesto_est_pre_id= '2' LIMIT 1) AS 'ultima_fecha_x_pagar' ,

miembro.membresia_id,
(SELECT  membresia.memb_descripcion FROM `membresia` WHERE membresia.memb_id= miembro.membresia_id) as 'memb_descripcion'
FROM  miembro  
INNER join persona on miembro.Persona_per_id = persona.per_id 
Left join presupuestocobro on miembro.mie_id = presupuestocobro.miembro_mie_id 
where  miembro.grupo_id= _id and presupuestocobro.precobro_year = _year and miembro.cancelled = 0


union


SELECT
miembro.mie_id,
miembro.grupo_id,
miembro.empresalocal_emp_id,
miembro. mie_fecharegistro,
(SELECT emp_nombre FROM empresalocal WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
persona.per_id ,  
persona.per_nombre, 
persona.per_apellido, 
(SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
         FROM persona, perfil, usuario 
         WHERE usuario.usu_id= miembro.forum_usu_id 
         and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum',
'' as precobro_id  ,
'' as precobro_fechainiciomiembro,
'' as precobro_valor ,
'' as periodo_perio_id,
'' as precobro_total  ,
'' as precobro_year ,
'' as  'precobro_periodo' ,
'' as  'fecha_x_pagar' ,
'' as  'ultima_fecha_x_pagar' ,

miembro.membresia_id,
(SELECT  membresia.memb_descripcion FROM `membresia` WHERE membresia.memb_id= miembro.membresia_id) as 'memb_descripcion'
FROM  miembro  
INNER join persona on miembro.Persona_per_id = persona.per_id  
where  miembro.grupo_id= _id and  miembro.mie_id not in (SELECT  `miembro_mie_id`  FROM `presupuestocobro` WHERE precobro_year =_year)
and miembro.cancelled = 0
ORDER BY mie_fecharegistro;
END;
