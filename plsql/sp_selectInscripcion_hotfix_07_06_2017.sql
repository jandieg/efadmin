CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectInscripcion`(IN `_id` INT)
BEGIN
    SELECT `mie_ins_id`, `mie_ins_valor`, `mie_ins_descripcion`, `mie_ins_id_usuario`, `mie_ins_fecharegistro`, `mie_ins_year`, `mie_ins_fechamodificacion`, `estado_cobro_id`, `mie_ins_fecha_cobro`, `mie_ins_fecha_ingreso` 
    FROM `miembro_inscripcion` 
    WHERE miembro_id=_id;
END;
