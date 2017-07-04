CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_updateEstadoMiembro`(_id_miembro int(11), _id_status int(11))
BEGIN
        if _id_status = '2' then
                UPDATE miembro 
                SET 
                status_member_id=_id_status, cancelled = 1, mie_fecha_cambio_status = now() 
                WHERE mie_id=_id_miembro;
        else
                UPDATE miembro 
                SET 
                status_member_id=_id_status
                WHERE mie_id=_id_miembro; 
        end if;
END;
