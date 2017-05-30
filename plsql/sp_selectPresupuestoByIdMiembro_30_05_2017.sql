CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectPresupuestoByIdMiembro`(_id_miembro int(11))
BEGIN
select precobro_id, precobro_valor, 
precobro_total, periodo_perio_id 
from presupuestocobro 
where miembro_mie_id = _id_miembro;
END;
