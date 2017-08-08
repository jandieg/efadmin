CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectCuotasPagas`(IN _id_precobro int(11))
BEGIN
select * from detallepresupuestocobro where presupuestocobro_precobro_id = _id_precobro 
and estado_presupuesto_est_pre_id = 2;
END;
