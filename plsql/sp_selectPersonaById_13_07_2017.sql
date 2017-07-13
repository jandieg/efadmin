CREATE DEFINER=`root`@`%` PROCEDURE `sp_selectPersonaById`(_id_persona int(11))
BEGIN
select * from persona where per_id = _id_persona;
END;
