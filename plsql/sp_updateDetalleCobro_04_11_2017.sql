CREATE PROCEDURE `sp_updateDetalleCobro`(IN _id int, IN _cobro double)
BEGIN
update detallepresupuestocobro set detalleprecobro_valor = _cobro where detalleprecobro_id = _id;
END;
