CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectGruposAndForumLeaders`(_agrup varchar(10))
BEGIN
if _agrup = '' then
select usuario.usu_user, grupos.gru_id 
from usuario join grupos 
on (grupos.gru_forum = usuario.usu_id)
order by usuario.usu_id, grupos.gru_id;   
else 
select usuario.usu_user, grupos.gru_id 
from usuario join grupos 
on (grupos.gru_forum = usuario.usu_id)
where grupos.agrup in (_agrup)
order by usuario.usu_id, grupos.gru_id;   
end if;

END;
