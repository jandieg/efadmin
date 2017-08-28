CREATE DEFINER='execforusm'@'localhost' PROCEDURE `sp_createUpdateIndustria`(IN _ind_id int(11),IN _ind_descripcion VARCHAR(100), IN _key int(11))
BEGIN
if _key = 1 then
update industria set ind_descripcion = _ind_descripcion, ind_fechamodificacion = now() where ind_id = _ind_id;
else 
insert into industria (ind_id, ind_descripcion, ind_id_usuario, ind_fecharegistro, ind_fechamodificacion, seccion_id) 
values (_ind_id, _ind_descripcion, 1, now(), now(), 1);
end if;
END;
