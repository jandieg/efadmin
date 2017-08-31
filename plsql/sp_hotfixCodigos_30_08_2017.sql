CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_hotfixCodigos`(nombre varchar(50), 
apellido varchar(50), codigo varchar(50), grupo varchar(50))
BEGIN
declare v_id int;
select miembro.mie_id into v_id from miembro join persona on persona.per_id = miembro.Persona_per_id 
where persona.per_nombre in (nombre) and persona.per_apellido in (apellido) limit 1;
update miembro set mie_codigo = codigo, miembro.grupo_id = fc_getGrupoByDesc(grupo) where miembro.mie_id = v_id;
END;
