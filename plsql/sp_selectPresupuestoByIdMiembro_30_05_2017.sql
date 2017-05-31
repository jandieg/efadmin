CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectPresupuestoByIdMiembro`(_id_miembro int(11))
BEGIN
  SELECT
    `precobro_id`, `precobro_valor`, `precobro_total`, `periodo_perio_id`
  FROM
    `presupuestocobro`
  WHERE
    `miembro_mie_id` = `_id_miembro` AND `precobro_year` = YEAR(CURDATE());
END;
