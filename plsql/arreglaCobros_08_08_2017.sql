CREATE DEFINER=`execforums`@`localhost` PROCEDURE `arreglarCobros`()
BEGIN
  DECLARE v_precobro_id int;
  DECLARE v_fecha_venc date;
  DECLARE done int DEFAULT FALSE;
  DECLARE cur1 CURSOR FOR
    SELECT presupuestocobro_precobro_id, detalleprecobro_fechavencimiento  FROM `detallepresupuestocobro` WHERE `estado_presupuesto_est_pre_id` = 2;
  DECLARE CONTINUE HANDLER FOR NOT FOUND
    SET done = TRUE;
  OPEN cur1;
  read_loop: LOOP
    FETCH cur1 INTO v_precobro_id, v_fecha_venc;
    IF done THEN
      LEAVE read_loop;
    END IF;
    delete from detallepresupuestocobro 
        where  presupuestocobro_precobro_id = v_precobro_id 
        and detalleprecobro_fechavencimiento = v_fecha_venc 
        and estado_presupuesto_est_pre_id = 1;
  END LOOP;
  CLOSE cur1;
END;