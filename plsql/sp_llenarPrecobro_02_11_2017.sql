CREATE PROCEDURE `sp_llenarPrecobro`()
BEGIN
 DECLARE done INT DEFAULT FALSE;

  DECLARE v_cobro, v_presup INT;
  DECLARE cur1 CURSOR FOR SELECT cobro_id, presupuestocobro_precobro_id FROM cobro order by cobro_fecharegistro asc;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

  OPEN cur1;

  read_loop: LOOP
    FETCH cur1 INTO v_cobro, v_presup;

    IF done THEN
      LEAVE read_loop;
    END IF;

    INSERT INTO presupuesto_cobro (presupuestocobro_id,cobro_id) VALUES (v_presup,v_cobro)
    ON DUPLICATE KEY UPDATE cobro_id=v_cobro;
    
  END LOOP;

  CLOSE cur1;

END;
