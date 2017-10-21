CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectGruposAndForumLeadersByUser`(IN _id_usuario int)
BEGIN
select usuario.usu_user, grupos.gru_id 
from usuario join grupos 
on (grupos.gru_forum = usuario.usu_id)
where usuario.sede_id = (select sede_id from usuario where usu_id = _id_usuario limit 1) 
order by usuario.usu_id, grupos.gru_id;   
END;
