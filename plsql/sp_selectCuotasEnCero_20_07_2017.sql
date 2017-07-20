CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectCuotasEnCero`(IN _id_precobro int(11))
BEGIN
select * from detallepresupuestocobro where presupuestocobro_precobro_id = _id_precobro 
and detalleprecobro_valor = 0;
END;
