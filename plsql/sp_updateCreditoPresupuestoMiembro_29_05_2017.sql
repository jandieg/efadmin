CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_updateCreditoPresupuestoMiembro`(_id_presupuesto int(11), _monto double, _bandera int(11))
BEGIN
  IF `_bandera` = 1 THEN
    UPDATE `presupuestocobro` SET `precobro_credito` = `_monto` WHERE `precobro_id` = `_id_presupuesto`;
  ELSE
    UPDATE `presupuestocobro` SET `precobro_credito` = IFNULL(`precobro_credito`, 0) + `_monto` WHERE `precobro_id` = `_id_presupuesto`;
  END IF;
END;
