CREATE DEFINER=execforums@localhost PROCEDURE `sp_selectUsuarioByPersona`(_id_persona int(11))
BEGIN
select * from usuario where Persona_per_id = _id_persona;
END;
