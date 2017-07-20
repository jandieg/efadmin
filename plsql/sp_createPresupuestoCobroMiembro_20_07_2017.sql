CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_createPresupuestoCobroMiembro`(IN `_valor` DOUBLE, IN `_fechainiciomiembro` TIMESTAMP, 
IN `_id_miembro` INT, IN `_cobro_total` DOUBLE, IN `_id_periodo` INT, IN `_fecharegistro` TIMESTAMP, 
IN `_id_usuario` VARCHAR(50), IN `_lista_fechas` VARCHAR(250), IN `_year` INT, IN `_id_membresia` INT, 
IN `_lista_fechas_faltantes` VARCHAR(250), IN `_valor_faltante` DOUBLE, IN `_id_tipo_presupuesto` INT, 
IN _cancelled INT, IN _fecha_cambio date)
BEGIN

 DECLARE _LID_CAB_PRESUPUESTO int;

    if(SELECT COUNT(`precobro_id`)  FROM `presupuestocobro` WHERE miembro_mie_id=_id_miembro and precobro_year = _year) = 0 then

        INSERT INTO presupuestocobro(precobro_valor, precobro_fechainiciomiembro, miembro_mie_id,  precobro_total, periodo_perio_id, precobro_fecharegistro, precobroi_fechamodificacion, precobro_id_usuario, precobro_year) 
                            VALUES (_valor,_fechainiciomiembro,_id_miembro,_cobro_total,_id_periodo,_fecharegistro,_fecharegistro,_id_usuario, _year);

        SET _LID_CAB_PRESUPUESTO = LAST_INSERT_ID();



        WHILE (LOCATE(',', _lista_fechas_faltantes) > 0)
        DO
            SET @value  = SUBSTRING(_lista_fechas_faltantes,1,LOCATE(',',_lista_fechas_faltantes) - 1);

            SET _lista_fechas_faltantes= SUBSTRING(_lista_fechas_faltantes, LOCATE(',',_lista_fechas_faltantes) + 1);

            INSERT INTO detallepresupuestocobro(tipo_presupusto_id, detalleprecobro_valor, detalleprecobro_fechavencimiento, presupuestocobro_precobro_id, estado_presupuesto_est_pre_id) 
            VALUES (_id_tipo_presupuesto, _valor_faltante,@value,_LID_CAB_PRESUPUESTO,(SELECT `est_pre_id` FROM `estado_presupuesto` LIMIT 1));



        END WHILE;



        WHILE (LOCATE(',', _lista_fechas) > 0)
        DO
            SET @value  = SUBSTRING(_lista_fechas,1,LOCATE(',',_lista_fechas) - 1);

            SET _lista_fechas= SUBSTRING(_lista_fechas, LOCATE(',',_lista_fechas) + 1);

            INSERT INTO detallepresupuestocobro(tipo_presupusto_id,  detalleprecobro_valor, detalleprecobro_fechavencimiento, presupuestocobro_precobro_id, estado_presupuesto_est_pre_id) 
            VALUES (_id_tipo_presupuesto,_valor,@value,_LID_CAB_PRESUPUESTO,(SELECT `est_pre_id` FROM `estado_presupuesto` LIMIT 1));



        END WHILE;
        
           if _cancelled = 1 then
                DELETE FROM `detallepresupuestocobro` WHERE presupuestocobro_precobro_id=_LID_CAB_PRESUPUESTO 
                and detalleprecobro_fechavencimiento > _fecha_cambio;
        end if;


        UPDATE `miembro` SET `membresia_id`=_id_membresia WHERE `mie_id`=_id_miembro;
    end if;	

END;
