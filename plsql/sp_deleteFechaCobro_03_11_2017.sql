CREATE PROCEDURE `sp_deleteFechaCobro`(_id int(11))
BEGIN
update miembro_inscripcion set mie_ins_fecha_cobro = NULL where mie_ins_id = _id;
END;