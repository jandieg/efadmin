CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_updateUsuario2`(IN `_id_user` INT, 
IN `_nombre` VARCHAR(200), IN `_apellido` VARCHAR(200), 
IN `_tipo` VARCHAR(20), IN `_identificacion` VARCHAR(50), 
IN `_fechanacimiento` DATE, IN `_genero` VARCHAR(20), 
IN `_perfil_id` INT, IN `_estado_user` VARCHAR(50), 
IN `_id_usuario` INT, IN `_correo` VARCHAR(200), 
IN `_telefono` VARCHAR(50), IN `_celular` VARCHAR(50), 
IN `_sede` INT, IN `_pais` INT, IN _esposa VARCHAR(50), 
IN _hijos VARCHAR(50))
BEGIN    
    UPDATE `usuario` SET `usu_estado`=_estado_user,`perfil_per_id`=_perfil_id, `per_id_usuario`=_id_usuario, sede_id = (SELECT  `sede_id` FROM `sede` WHERE pais_pai_id=_pais) , pais_id = _pais WHERE `usu_id`=_id_user;
    UPDATE `persona` SET `per_nombre`=_nombre,`per_apellido`=_apellido,`per_tipo`=_tipo,
        `per_identificacion`=_identificacion,`per_fechanacimiento`=_fechanacimiento,
        `per_genero`=_genero, per_hijos= _hijos, per_esposa = _esposa  
    WHERE `per_id`=(SELECT  `Persona_per_id` FROM `usuario` WHERE usu_id=_id_user);

    UPDATE `telefono` SET `tel_descripcion`=_celular, `tel_id_usuario`=_id_usuario WHERE `Persona_per_id`= (SELECT  `Persona_per_id` FROM `usuario` WHERE usu_id=_id_user) and `tel_tipo`='M';
    UPDATE `telefono` SET `tel_descripcion`=_telefono, `tel_id_usuario`=_id_usuario WHERE `Persona_per_id`= (SELECT  `Persona_per_id` FROM `usuario` WHERE usu_id=_id_user) and `tel_tipo`='C';
    UPDATE `correo` SET `cor_descripcion`=_correo,`cor_id_usuario`=_id_usuario WHERE `Persona_per_id`=(SELECT  `Persona_per_id` FROM `usuario` WHERE usu_id=_id_user) and cor_tipo='Personal';

END;
