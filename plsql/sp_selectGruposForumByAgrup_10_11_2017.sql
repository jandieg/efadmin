CREATE PROCEDURE `sp_selectGruposForumByAgrup`(_id int(11), _agrup varchar(10))
BEGIN
        if _agrup = '' then
        SELECT `gru_id`, `gru_descripcion` FROM `grupos` WHERE gru_forum= _id;
        else
        SELECT `gru_id`, `gru_descripcion` FROM `grupos` WHERE gru_forum= _id and agrup= _agrup;
        end if;
END;
