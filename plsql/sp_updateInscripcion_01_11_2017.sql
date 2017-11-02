CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_updateInscripcion`(IN `_id` INT, IN `_valor` DOUBLE, IN `_id_usuario` INT, IN `_fecha_inscripcion` DATE, IN `_estado` INT, IN `_ins_fecha_cobro` TIMESTAMP)
BEGIN

declare v_mie_id int;
declare _fechas timestamp;

if _ins_fecha_cobro is null then
 UPDATE `miembro_inscripcion` 
    SET `mie_ins_valor`=0,`mie_ins_id_usuario`=_id_usuario, `mie_ins_year`=year(_fecha_inscripcion), 
    `mie_ins_fecha_ingreso`=_fecha_inscripcion, `mie_ins_fecharegistro`=concat(_fecha_inscripcion,' 00:00:00'), 
    estado_cobro_id=_estado, mie_ins_fecha_cobro = NULL
    WHERE `mie_ins_id`=_id;
else 
 UPDATE `miembro_inscripcion` 
    SET `mie_ins_valor`=_valor,`mie_ins_id_usuario`=_id_usuario, `mie_ins_year`=year(_fecha_inscripcion), 
    `mie_ins_fecha_ingreso`=_fecha_inscripcion, `mie_ins_fecharegistro`=concat(_fecha_inscripcion,' 00:00:00'), 
    estado_cobro_id=_estado, mie_ins_fecha_cobro = _ins_fecha_cobro
    WHERE `mie_ins_id`=_id;
end if;
  
select miembro_id into v_mie_id from miembro_inscripcion where mie_ins_id = _id;  
  
SELECT mie_ins_fecharegistro into _fechas FROM miembro_inscripcion 
WHERE miembro_id =v_mie_id ORDER BY mie_ins_fecharegistro ASC LIMIT 1;

update miembro set mie_fecharegistro= _fechas where mie_id = _id_miembro;
  
  
END;
