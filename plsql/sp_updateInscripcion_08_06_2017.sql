CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_updateInscripcion`(IN `_id` INT, IN `_valor` DOUBLE, IN `_id_usuario` INT, IN `_fecha_inscripcion` DATE, IN `_estado` INT, IN `_ins_fecha_cobro` TIMESTAMP)
BEGIN
   UPDATE `miembro_inscripcion` 
    SET `mie_ins_valor`=_valor,`mie_ins_id_usuario`=_id_usuario, `mie_ins_year`=year(_fecha_inscripcion), `mie_ins_fecha_ingreso`=_fecha_inscripcion, estado_cobro_id=_estado, mie_ins_fecha_cobro = _ins_fecha_cobro
    WHERE `mie_ins_id`=_id;
END;
