CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_globalCreateUsuario`(IN `_nombre` VARCHAR(50), IN `_apellido` VARCHAR(50), IN `_tipo` VARCHAR(20), IN `_identificacion` VARCHAR(50), IN `_fechanacimiento` DATE, IN `_genero` VARCHAR(20), IN `_user` VARCHAR(150), IN `_pass` TEXT, IN `_perfil_id` INT, IN `_fecharegistro` TIMESTAMP, IN `_estado_user` VARCHAR(50), IN `_id_usuario` INT, IN `_correo` VARCHAR(50), IN `_telefono` VARCHAR(50), IN `_celular` VARCHAR(50), IN `_salt` TEXT, IN `_sede` INT, 
IN `_db` TEXT, IN `_pais` VARCHAR(30), IN _sede2 varchar(30))
BEGIN
	
    DECLARE _LID_PERSONA int;
    
   
     IF ((SELECT Count(usu_id) FROM execforums.usuario WHERE binary usu_user= _user ) > 0  or (SELECT Count(usu_id) FROM execforums.usuario WHERE binary usu_user= _user ) > 0 )   then
            SELECT  'NO' as '_key' ;
     else
          
        INSERT INTO persona(per_nombre, per_apellido, per_tipo, per_identificacion, per_fechanacimiento, per_genero) 
        VALUES (_nombre,_apellido,_tipo,_identificacion,_fechanacimiento,_genero);
        
        SET _LID_PERSONA = LAST_INSERT_ID();

        INSERT INTO usuario( usu_user, usu_pass, perfil_per_id, usu_fecharegistro, usu_estado, Persona_per_id, per_id_usuario, usu_salt, sede_id, usuario.configuracion_id, pais_id) 
        VALUES (_user,_pass,_perfil_id,_fecharegistro,_estado_user,_LID_PERSONA,_id_usuario,_salt, _sede2,'1', _pais);

        INSERT INTO correo( cor_tipo,cor_descripcion, cor_fecharegistro, Persona_per_id, cor_id_usuario, cor_estado) 
        VALUES ('Personal',_correo,_fecharegistro,_LID_PERSONA,_id_usuario,'A');

        INSERT INTO telefono( tel_descripcion, tel_fecharegistro,Persona_per_id, tel_tipo, tel_id_usuario, tel_estado) VALUES 
        (_telefono,_fecharegistro,_LID_PERSONA,'C',_id_usuario,'A');

        INSERT INTO telefono( tel_descripcion, tel_fecharegistro,Persona_per_id, tel_tipo, tel_id_usuario, tel_estado) VALUES 
        (_celular,_fecharegistro,_LID_PERSONA,'M',_id_usuario,'A');

         SELECT Count(usu_id), 'OK' as '_key' FROM usuario WHERE binary usu_user= _user;
        
    end if;
END;
