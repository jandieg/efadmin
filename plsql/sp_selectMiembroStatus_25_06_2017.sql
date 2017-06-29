CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectMiembroStatus`()
BEGIN
select * from member_status where mem_sta_id in (1,2,3,4);
END;
