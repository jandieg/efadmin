CREATE DEFINER = 'execforums'@'localhost' PROCEDURE `sp_cancelPresupuestoCobroMiembro`(
  _id_miembro int(11),
  _mes int(11),
  _anho int(11),
  _fecha datetime
)
BEGIN
  UPDATE `miembro` SET `mie_fecha_cambio_status` = `_fecha` WHERE `mie_id` = `_id_miembro`;
  DELETE
  FROM
    `detallepresupuestocobro`
  WHERE
    YEAR(`detalleprecobro_fechavencimiento`) >= `_anho`
      AND `estado_presupuesto_est_pre_id` = 1
      AND MONTH(`detalleprecobro_fechavencimiento`) > `_mes`
      AND `presupuestocobro_precobro_id` = (SELECT `precobro_id` FROM `presupuestocobro` WHERE `miembro_mie_id` = `_id_miembro`);
END;