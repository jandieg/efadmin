CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectAllMembers`(_agrup varchar(10))
BEGIN
if _agrup = '' then
select * from miembro join persona on miembro.Persona_per_id= persona.per_id
and cancelled = 0
order by miembro.grupo_id, persona.per_nombre;
else 
select * from miembro join persona on miembro.Persona_per_id= persona.per_id
and cancelled = 0 and miembro.grupo_id in (select gru_id from grupos where agrup in (_agrup))
order by miembro.grupo_id, persona.per_nombre;
end if;
END;
