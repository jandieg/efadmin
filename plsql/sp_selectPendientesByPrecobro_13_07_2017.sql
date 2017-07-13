CREATE DEFINER=execforums@localhost PROCEDURE `sp_selectPendientesByPrecobro`(_precobro_id int(11))
BEGIN
select * from detallepresupuestocobro where presupuestocobro_precobro_id = _precobro_id 
and estado_presupuesto_est_pre_id = 1;
END;
