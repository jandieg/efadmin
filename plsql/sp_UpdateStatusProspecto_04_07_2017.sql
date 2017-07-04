CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_UpdateStatusProspecto`(_id_prospecto int(11), _estado int(11))
BEGIN
update prospecto set status_member_id = _estado where pro_id = _id_prospecto;
END;
