CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_createInscripcion`(IN `_valor` DOUBLE, IN `_id_miembro` INT, IN `_fecharegistro` TIMESTAMP, IN `_id_usuario` INT, IN `_fecha_inscripcion` DATE, IN `_estado` INT, IN `_year` INT, IN `_ins_fecha_cobro` TIMESTAMP)
BEGIN
declare _fechas timestamp;
IF _ins_fecha_cobro is null then 
INSERT INTO `miembro_inscripcion`( `mie_ins_valor`,`mie_ins_id_usuario`, `mie_ins_fecharegistro`, `mie_ins_fechamodificacion`, `miembro_id`, 
                                         `mie_ins_fecha_ingreso`,estado_cobro_id, mie_ins_year, mie_ins_fecha_cobro) 
    VALUES (0,_id_usuario,_fecharegistro,_fecharegistro,_id_miembro,_fecha_inscripcion,_estado, _year, NULL);
else
INSERT INTO `miembro_inscripcion`( `mie_ins_valor`,`mie_ins_id_usuario`, `mie_ins_fecharegistro`, `mie_ins_fechamodificacion`, `miembro_id`, 
                                         `mie_ins_fecha_ingreso`,estado_cobro_id, mie_ins_year, mie_ins_fecha_cobro) 
    VALUES (_valor,_id_usuario,_fecharegistro,_fecharegistro,_id_miembro,_fecha_inscripcion,_estado, _year, _ins_fecha_cobro);
   
end if;

SELECT mie_ins_fecharegistro into _fechas FROM miembro_inscripcion 
WHERE miembro_id =_id_miembro ORDER BY mie_ins_fecharegistro ASC LIMIT 1;

update miembro set mie_fecharegistro= _fechas where mie_id = _id_miembro;

END;
