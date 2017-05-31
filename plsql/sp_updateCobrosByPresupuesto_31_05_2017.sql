CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_updateCobrosByPresupuesto`(IN _id_presupuestocobro int, IN _lista_detalle_presupuestocobro varchar(250), IN _id_miembro int)
BEGIN
  DECLARE _LID_COBRO int;
  DECLARE done int DEFAULT FALSE;
  DECLARE cur1 CURSOR FOR
    SELECT `cobro_id` FROM `cobro` WHERE `presupuesto_precobro_id` = `_id_presupuestocobro` AND `miembro_id` = `_id_miembro`;
  DECLARE CONTINUE HANDLER FOR NOT FOUND
    SET done = TRUE;
  OPEN cur1;
  read_loop: LOOP
    FETCH cur1 INTO _LID_COBRO;
    IF done THEN
      LEAVE read_loop;
    END IF;
    UPDATE `cobro` SET `cobro_total` = (SELECT IFNULL(SUM(`cobro_total`), 0) FROM `detallecobro` WHERE `cobro_cobro_id` = _LID_COBRO) WHERE `cobro_id` = _LID_COBRO;
    IF (SELECT IFNULL(COUNT(`det_cobro_id`), 0) FROM `detallecobro` WHERE `cobro_cobro_id` = _LID_COBRO) > 0 THEN
      UPDATE `cobro_grupo_pago` SET `cgp_valor` = (SELECT `cobro_total` FROM `cobro` WHERE `cobro_id` = _LID_COBRO) WHERE `cobro_id` = _LID_COBRO AND `grupos_gru_id` = (SELECT `grupo_id` FROM `miembro` WHERE `mie_id` = `_id_miembro`);
    ELSE
      DELETE FROM `cobro` WHERE `cobro_id` = _LID_COBRO;
    END IF;
  END LOOP;
  CLOSE cur1;
END;
