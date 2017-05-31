CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_reverseCobro`(
  IN _id_presupuestocobro int,
  IN _lista_detalle_presupuestocobro varchar(250),
  IN _id_miembro int
)
BEGIN


  IF `_lista_detalle_presupuestocobro` <> '' THEN
    WHILE (LOCATE(',', `_lista_detalle_presupuestocobro`) > 0) DO
      SET @value = ELT(1, `_lista_detalle_presupuestocobro`);
      SET `_lista_detalle_presupuestocobro` = SUBSTRING(`_lista_detalle_presupuestocobro`,LOCATE(',', `_lista_detalle_presupuestocobro`) + 1);
      IF (SELECT `estado_presupuesto_est_pre_id` FROM `detallepresupuestocobro` WHERE `detalleprecobro_id` = @value) = '2' THEN
        delete from detallecobro where miembro_mie_id = _id_miembro 
        and detallepresupuestocobro_detalleprecobro_id = @value;
        UPDATE `detallepresupuestocobro` SET `estado_presupuesto_est_pre_id` = '1' WHERE `detalleprecobro_id` = @value;
      END IF;
    END WHILE;
      
  END IF;
  
      

END;
