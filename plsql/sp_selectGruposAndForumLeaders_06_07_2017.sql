CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectGruposAndForumLeaders`()
BEGIN
select usuario.usu_user, grupos.gru_id 
from usuario join grupos 
on (grupos.gru_forum = usuario.usu_id)
order by usuario.usu_id, grupos.gru_id;   
END;
