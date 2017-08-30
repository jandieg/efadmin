CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_createMiembroFromScript`(_id_empresa varchar(100), _mie_fecharegistro timestamp,
_codigo_grupo varchar(10), _miembro_id varchar(10), _membresia_id int, _status_member_id int, 
_mie_observacion text, _precio_esp varchar(50), _mie_fecha_cancelacion timestamp, 
_cancelled int, _per_nombre varchar(200), _per_apellido varchar(200), _per_tipo varchar(45),
_per_fechanacimiento date, _per_genero varchar(45), _per_hijos varchar(50), _per_esposa varchar(50),
_email varchar(100), _telefono varchar(45), _celular varchar(45), _direccion varchar(200))
BEGIN
declare v_per_id  int;
if (select count(*) from persona 
    where per_nombre in (_per_nombre) 
    and per_apellido in (_per_apellido) ) > 0 then
    select per_id into v_per_id from persona where per_nombre in (_per_nombre) 
    and per_apellido in (_per_apellido);
else 
    insert into persona (per_nombre, per_apellido, per_tipo, per_fechanacimiento, 
    per_genero, per_hijos, per_esposa) values (_per_nombre, _per_apellido, _per_tipo, 
    _per_fechanacimiento, _per_genero, _per_hijos, _per_esposa);
    set v_per_id = last_insert_id();
end if;

INSERT INTO correo( cor_tipo,cor_descripcion, cor_fecharegistro, Persona_per_id, cor_id_usuario, cor_estado) 
VALUES ('Personal',_email,_mie_fecharegistro,v_per_id,1,'A');

INSERT INTO telefono( tel_descripcion, tel_fecharegistro,Persona_per_id, tel_tipo, tel_id_usuario, tel_estado) VALUES 
(_telefono,_mie_fecharegistro,v_per_id,'C',1,'A');

INSERT INTO telefono( tel_descripcion, tel_fecharegistro,Persona_per_id, tel_tipo, tel_id_usuario, tel_estado) VALUES 
(_celular,_mie_fecharegistro,v_per_id,'M',1,'A');

insert into miembro (empresalocal_emp_id, mie_id_usuario, mie_fecharegistro, 
mie_fechamodificacion, grupo_id, mie_codigo, Persona_per_id, forum_usu_id, 
mie_participacion_correo, membresia_id, status_member_id, mie_observacion,
precio_esp, mie_fecha_cambio_status, cancelled,secret, categoria_cat_id, Profesion_prof_id) 
values (fc_getEmpresaByNombre(_id_empresa), 1, _mie_fecharegistro, _mie_fecharegistro, 
fc_getGrupoByDesc(_codigo_grupo), _miembro_id, v_per_id, fc_getFlGrupoByDesc(_codigo_grupo), 1, _membresia_id, 
_status_member_id, _mie_observacion, _precio_esp, _mie_fecha_cancelacion, _cancelled, '654321', 2, 1);

END;
