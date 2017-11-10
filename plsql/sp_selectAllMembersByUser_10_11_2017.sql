CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectAllMembersByUser`(IN `_id_usuario` INT, _agrup varchar(10))
BEGIN
declare v_sede int;
select sede_id into v_sede from usuario where usu_id = _id_usuario limit 1;
if _agrup = '' then
select * from miembro join persona on miembro.Persona_per_id= persona.per_id
and cancelled = 0
where miembro.grupo_id in (select gru_id from grupos where sede_id = v_sede)
order by miembro.grupo_id, persona.per_nombre;
else 
select * from miembro join persona on miembro.Persona_per_id= persona.per_id
and cancelled = 0
where miembro.grupo_id in (select gru_id from grupos where sede_id = v_sede and agrup in (_agrup))
order by miembro.grupo_id, persona.per_nombre;
end if;
END;
