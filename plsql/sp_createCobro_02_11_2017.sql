CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_createCobro`(IN `_id_presupuestocobro` INT, IN `_lista_detalle_presupuestocobro` VARCHAR(250), IN `_id_miembro` INT, IN `_id_forma_pago` INT, IN `_fecharegistro` TIMESTAMP, IN `_id_usuario` INT)
BEGIN

 DECLARE _LID_COBRO int;

            INSERT INTO cobro( presupuestocobro_precobro_id, cobro_fecharegistro, cobro_fechamodificacion, cobro_id_usuario, miembro_id) 
            VALUES (_id_presupuestocobro,_fecharegistro,_fecharegistro,_id_usuario,_id_miembro);

            SET _LID_COBRO = LAST_INSERT_ID();
            
            INSERT INTO presupuesto_cobro (presupuestocobro_id,cobro_id) VALUES (_id_presupuestocobro,_LID_COBRO)
            ON DUPLICATE KEY UPDATE cobro_id=_LID_COBRO;

             if _lista_detalle_presupuestocobro <> '' then  
                WHILE (LOCATE(',', _lista_detalle_presupuestocobro) > 0)
                DO
                    SET @value = ELT(1, _lista_detalle_presupuestocobro);
                    SET _lista_detalle_presupuestocobro= SUBSTRING(_lista_detalle_presupuestocobro, LOCATE(',',_lista_detalle_presupuestocobro) + 1);

                    if (SELECT  estado_presupuesto_est_pre_id FROM detallepresupuestocobro WHERE detalleprecobro_id= @value) = '1' then
					
                        INSERT INTO detallecobro( miembro_mie_id, cobro_cobro_id, detallepresupuestocobro_detalleprecobro_id, formapago_for_pag_id, cobro_total, det_cobro_fecharegistro, det_cobro_fechamodificacion, det_cobro_id_usuario) 
                        VALUES (_id_miembro,_LID_COBRO,@value,_id_forma_pago,(SELECT detalleprecobro_valor  FROM detallepresupuestocobro WHERE detalleprecobro_id=@value),_fecharegistro,_fecharegistro,_id_usuario);
                        
                         UPDATE detallepresupuestocobro SET  estado_presupuesto_est_pre_id='2' WHERE detalleprecobro_id=@value;
        
                    end if;
                END WHILE;
            end if;
            UPDATE cobro SET cobro_total=(SELECT  sum(cobro_total) FROM detallecobro WHERE cobro_cobro_id= _LID_COBRO) WHERE cobro_id=_LID_COBRO;

 if (SELECT count(`det_cobro_id`) FROM `detallecobro` WHERE cobro_cobro_id = _LID_COBRO) > 0 then 

            INSERT INTO `cobro_grupo_pago`( `cobro_id`, `cgp_valor`, `grupos_gru_id`, `cgp_estado_pago_grupo`, `cgp_estado_pago_franquicia`, `cgp_id_usuario`, `cgp_fecharegistro`, `cgp_fechamodificacion`) 
            VALUES (_LID_COBRO,(SELECT `cobro_total` FROM `cobro` WHERE cobro_id=_LID_COBRO),(SELECT `grupo_id` FROM `miembro` WHERE mie_id=_id_miembro),'0','0',_id_usuario,_fecharegistro,_fecharegistro);
	else
	DELETE FROM `cobro` WHERE cobro_id=_LID_COBRO;
end if;			


  
END;
