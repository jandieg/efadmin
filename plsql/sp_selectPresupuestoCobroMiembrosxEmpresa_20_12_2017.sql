CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectPresupuestoCobroMiembrosxEmpresa`(IN `_id` INT, IN `_year` INT)
BEGIN
declare v_anhoant int;
set v_anhoant = year(curdate()) - 1;
  if _year = year(curdate()) then
   (SELECT
    miembro.mie_id,
    miembro.grupo_id,
    miembro.cancelled,
    miembro.empresalocal_emp_id,
    miembro. mie_fecharegistro,
    (SELECT  `mie_ins_valor` FROM `miembro_inscripcion` WHERE mie_ins_year= _year and miembro_id = miembro.mie_id and estado_cobro_id='1') as 'valor_inscripcion',
    (SELECT emp_nombre FROM empresalocal WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
    persona.per_id ,  
    persona.per_nombre, 
    persona.per_apellido, 
    presupuestocobro.precobro_id
    FROM  miembro  
    INNER join persona on miembro.Persona_per_id = persona.per_id 
    Left join presupuestocobro on miembro.mie_id = presupuestocobro.miembro_mie_id 
    where 
    miembro.mie_id in (SELECT  `miembro_mie_id` FROM `miembro_empresa` WHERE empresalocal_emp_id=_id)
    and  (presupuestocobro.precobro_year=_year or presupuestocobro.precobro_year is null)
    ORDER BY mie_fecharegistro)
    union
    (SELECT
    miembro.mie_id,
    miembro.grupo_id,
    miembro.cancelled,
    miembro.empresalocal_emp_id,
    miembro. mie_fecharegistro,
    (SELECT  `mie_ins_valor` FROM `miembro_inscripcion` WHERE mie_ins_year= _year and miembro_id = miembro.mie_id and estado_cobro_id='1') as 'valor_inscripcion',
    (SELECT emp_nombre FROM empresalocal WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
    persona.per_id ,  
    persona.per_nombre, 
    persona.per_apellido, 
    presupuestocobro.precobro_id
    FROM  miembro  
    INNER join persona on miembro.Persona_per_id = persona.per_id 
    Left join presupuestocobro on miembro.mie_id = presupuestocobro.miembro_mie_id 
    where 
    miembro.mie_id in (SELECT  `miembro_mie_id` FROM `miembro_empresa` WHERE empresalocal_emp_id=_id)
    and miembro.cancelled = 0 
    and  (presupuestocobro.precobro_year= v_anhoant)
    ORDER BY mie_fecharegistro);
  else 
   SELECT
    miembro.mie_id,
    miembro.grupo_id,
    miembro.cancelled,
    miembro.empresalocal_emp_id,
    miembro. mie_fecharegistro,
    (SELECT  `mie_ins_valor` FROM `miembro_inscripcion` WHERE mie_ins_year= _year and miembro_id = miembro.mie_id and estado_cobro_id='1') as 'valor_inscripcion',
    (SELECT emp_nombre FROM empresalocal WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
    persona.per_id ,  
    persona.per_nombre, 
    persona.per_apellido, 
    presupuestocobro.precobro_id
    FROM  miembro  
    INNER join persona on miembro.Persona_per_id = persona.per_id 
    Left join presupuestocobro on miembro.mie_id = presupuestocobro.miembro_mie_id 
    where 
    miembro.mie_id in (SELECT  `miembro_mie_id` FROM `miembro_empresa` WHERE empresalocal_emp_id=_id)
    and  (presupuestocobro.precobro_year=_year or presupuestocobro.precobro_year is null)
    ORDER BY mie_fecharegistro;
  end if;
END;
