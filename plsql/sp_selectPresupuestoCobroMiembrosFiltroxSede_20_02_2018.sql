CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectPresupuestoCobroMiembrosFiltroxSede`(IN `_id` INT, IN `_year` INT)
BEGIN
declare v_anhoant int;
select year(curdate())-1 into v_anhoant;

  if _year = year(curdate()) then
  (SELECT
    miembro.mie_id,
    miembro.grupo_id,
    miembro.empresalocal_emp_id,
    miembro.cancelled,
    miembro. mie_fecharegistro,
    (SELECT  `mie_ins_valor` FROM `miembro_inscripcion` WHERE miembro_id = miembro.mie_id and estado_cobro_id='1' limit 1) as 'valor_inscripcion',
    (SELECT emp_nombre FROM empresalocal WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
    persona.per_id ,  
    persona.per_nombre, 
    persona.per_apellido, 
    presupuestocobro.precobro_id
    FROM  miembro  
    INNER join persona on miembro.Persona_per_id = persona.per_id 
    Left join presupuestocobro on miembro.mie_id = presupuestocobro.miembro_mie_id 
    where miembro.grupo_id in (select gru_id from grupos where sede_id = _id) 
    and  (presupuestocobro.precobro_year=_year 
    or presupuestocobro.precobro_year is null)
    ORDER BY mie_fecharegistro)
    union
    (SELECT
    miembro.mie_id,
    miembro.grupo_id,
    miembro.empresalocal_emp_id,
    miembro.cancelled,
    miembro. mie_fecharegistro,
    (SELECT  `mie_ins_valor` FROM `miembro_inscripcion` WHERE miembro_id = miembro.mie_id and estado_cobro_id='1' limit 1) as 'valor_inscripcion',
    (SELECT emp_nombre FROM empresalocal WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
    persona.per_id ,  
    persona.per_nombre, 
    persona.per_apellido, 
    presupuestocobro.precobro_id
    FROM  miembro  
    INNER join persona on miembro.Persona_per_id = persona.per_id 
    Left join presupuestocobro on miembro.mie_id = presupuestocobro.miembro_mie_id 
    where miembro.grupo_id in (select gru_id from grupos where sede_id = _id) 
    and (presupuestocobro.precobro_year=v_anhoant)
    and miembro.cancelled = 1 
    ORDER BY mie_fecharegistro);
  else     
   SELECT
    miembro.mie_id,
    miembro.grupo_id,
    miembro.empresalocal_emp_id,
    miembro.cancelled,
    miembro. mie_fecharegistro,
    (SELECT  `mie_ins_valor` FROM `miembro_inscripcion` WHERE miembro_id = miembro.mie_id and estado_cobro_id='1' limit 1) as 'valor_inscripcion',
    (SELECT emp_nombre FROM empresalocal WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
    persona.per_id ,  
    persona.per_nombre, 
    persona.per_apellido, 
    presupuestocobro.precobro_id
    FROM  miembro  
    INNER join persona on miembro.Persona_per_id = persona.per_id 
    Left join presupuestocobro on miembro.mie_id = presupuestocobro.miembro_mie_id 
    where miembro.grupo_id in (select gru_id from grupos where sede_id = _id) 
    and (presupuestocobro.precobro_year=_year or presupuestocobro.precobro_year is null)
    ORDER BY mie_fecharegistro;
    end if;
END;
