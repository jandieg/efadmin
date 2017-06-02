CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectDetallePresupuestoMiembroByAnho`(IN _id_miembro int, IN _anho int)
BEGIN
  SELECT
    `detallepresupuestocobro`.`detalleprecobro_id`,
    `detallepresupuestocobro`.`detalleprecobro_numero`,
    `detallepresupuestocobro`.`detalleprecobro_valor`,
    `detallepresupuestocobro`.`detalleprecobro_fechavencimiento`,
    `detallepresupuestocobro`.`estado_presupuesto_est_pre_id`,
    (SELECT `est_pre_descripcion` FROM `estado_presupuesto` WHERE `est_pre_id` = `detallepresupuestocobro`.`estado_presupuesto_est_pre_id`) AS 'detalleprecobro_estado'
  FROM `detallepresupuestocobro` 
  JOIN presupuestocobro 
  ON (`detallepresupuestocobro`.`presupuestocobro_precobro_id` = presupuestocobro.precobro_id )
  WHERE presupuestocobro.miembro_mie_id = _id_miembro
  AND presupuestocobro.precobro_year = _anho
  ORDER BY
    `detallepresupuestocobro`.`detalleprecobro_fechavencimiento`;
END;
