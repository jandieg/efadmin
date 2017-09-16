CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_hotfixInscripcion`(nombre varchar(50), 
apellido varchar(50), _registro timestamp, _ingreso date,
_anho int, _cobro timestamp, _estado int, _valor double, _membresia int)
BEGIN
declare v_id int;
select miembro.mie_id into v_id from miembro join persona on persona.per_id = miembro.Persona_per_id 
where persona.per_nombre in (nombre) and persona.per_apellido in (apellido) limit 1;

insert into miembro_inscripcion (mie_ins_valor, mie_ins_id_usuario, mie_ins_fecharegistro, 
mie_ins_fechamodificacion, miembro_id, estado_cobro_id, 
mie_ins_fecha_cobro, mie_ins_fecha_ingreso, mie_ins_year)
values (_valor, 1, _registro, _registro, v_id, _estado, _cobro, _ingreso, _anho);
END;
