CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectCreditoPresupuestoMiembro`(IN _id_precobro int(11))
BEGIN
select ifnull(precobro_credito,0) as precobro_credito from presupuestocobro where precobro_id = _id_precobro;
END;
