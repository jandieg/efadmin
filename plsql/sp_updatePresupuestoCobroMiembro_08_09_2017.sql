CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_updatePresupuestoCobroMiembro`(IN `_id_presupuesto` INT, 
IN `_valor` DOUBLE, IN `_cobro_total` DOUBLE, IN `_id_periodo` INT, IN `_id_usuario` VARCHAR(50), 
IN `_lista_fechas` VARCHAR(250), IN `_id_membresia` INT, IN `_id_miembro` INT, IN `_lista_fechas_faltantes` VARCHAR(250), 
IN `_valor_faltante` DOUBLE, IN `_id_tipo_presupuesto` INT, IN `_year` INT, IN _cancelled INT, IN _fecha_cambio date)
BEGIN
   if(SELECT COUNT(`precobro_id`)  FROM `presupuestocobro` WHERE miembro_mie_id=_id_miembro and precobro_year = _year) > 0 then
        UPDATE presupuestocobro 
        SET precobro_valor=_valor, precobro_total=_cobro_total,periodo_perio_id=_id_periodo,precobro_id_usuario=_id_usuario
        WHERE precobro_id=_id_presupuesto;

        DELETE FROM `detallepresupuestocobro` WHERE presupuestocobro_precobro_id=_id_presupuesto and estado_presupuesto_est_pre_id= '1';



        WHILE (LOCATE(',', _lista_fechas_faltantes) > 0)
        DO
            SET @value  = SUBSTRING(_lista_fechas_faltantes,1,LOCATE(',',_lista_fechas_faltantes) - 1);

            SET _lista_fechas_faltantes= SUBSTRING(_lista_fechas_faltantes, LOCATE(',',_lista_fechas_faltantes) + 1);

            INSERT INTO detallepresupuestocobro(tipo_presupusto_id, detalleprecobro_valor, detalleprecobro_fechavencimiento, presupuestocobro_precobro_id, estado_presupuesto_est_pre_id) 
            VALUES (_id_tipo_presupuesto,_valor_faltante,@value,_id_presupuesto,(SELECT `est_pre_id` FROM `estado_presupuesto` LIMIT 1));



        END WHILE;



        WHILE (LOCATE(',', _lista_fechas) > 0)
        DO
            SET @value  = SUBSTRING(_lista_fechas,1,LOCATE(',',_lista_fechas) - 1);

            SET _lista_fechas= SUBSTRING(_lista_fechas, LOCATE(',',_lista_fechas) + 1);

            INSERT INTO detallepresupuestocobro(tipo_presupusto_id,  detalleprecobro_valor, detalleprecobro_fechavencimiento, presupuestocobro_precobro_id, estado_presupuesto_est_pre_id) 
            VALUES (_id_tipo_presupuesto,_valor,@value,_id_presupuesto,(SELECT `est_pre_id` FROM `estado_presupuesto` LIMIT 1));


        END WHILE;
        
        if _cancelled = 1 then
                DELETE FROM `detallepresupuestocobro` WHERE presupuestocobro_precobro_id=_id_presupuesto 
                and detalleprecobro_fechavencimiento > _fecha_cambio;
        end if;
        update detallepresupuestocobro set detalleprecobro_valor = _valor where 	estado_presupuesto_est_pre_id = 1 
        and presupuestocobro_precobro_id in (SELECT precobro_id  FROM `presupuestocobro` WHERE miembro_mie_id=_id_miembro ); 
        
        update presupuestocobro set precobro_valor = _valor 
        where precobro_id in (select t2.presupuestocobro_precobro_id from detallepresupuestocobro as t2 
        where t2.estado_presupuesto_est_pre_id = 1) and miembro_mie_id = _id_miembro;
        
        UPDATE `miembro` SET `membresia_id`=_id_membresia WHERE `mie_id`=_id_miembro;
  else 
        UPDATE `miembro` SET `membresia_id`=_id_membresia WHERE `mie_id`=_id_miembro;
        if _cancelled = 1 then
                DELETE FROM `detallepresupuestocobro` WHERE presupuestocobro_precobro_id=_id_presupuesto 
                and detalleprecobro_fechavencimiento > _fecha_cambio;
        end if;
        update detallepresupuestocobro set detalleprecobro_valor = _valor where 	estado_presupuesto_est_pre_id = 1 
        and presupuestocobro_precobro_id in (SELECT precobro_id  FROM `presupuestocobro` WHERE miembro_mie_id=_id_miembro ); 
                
        update presupuestocobro set precobro_valor = _valor 
        where precobro_id in (select t2.presupuestocobro_precobro_id from detallepresupuestocobro as t2 
        where t2.estado_presupuesto_est_pre_id = 1) and miembro_mie_id = _id_miembro;
   end if;

END;
