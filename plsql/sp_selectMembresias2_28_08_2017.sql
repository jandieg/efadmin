CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectMembresias2`(IN `_estado` varchar(10), IN _id_user int)
BEGIN
declare v_sede int;
   SELECT sede_id into v_sede from usuario where usu_id=_id_user;
   SELECT membresia.* 
    FROM `membresia` join usuario on membresia.memb_id_usuario = usuario.usu_id 
        WHERE memb_estado =_estado and usuario.sede_id = v_sede;
END;
