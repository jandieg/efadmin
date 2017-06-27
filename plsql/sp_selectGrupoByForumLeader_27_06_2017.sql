CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectGrupoByForumLeader`(_id_forum_leader int(11))
BEGIN
select * from grupos where gru_forum = _id_forum_leader;
END;
