CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectGrupoKey`(IN `_id` INT, IN `_key` INT)
BEGIN
        if _key = '1' then
            SELECT `gru_id`, `gru_descripcion`,`gru_forum` FROM `grupos` WHERE gru_id=_id;
        end if;
        if _key = '2' then
            SELECT `gru_id`, `gru_descripcion`,`gru_forum` FROM `grupos` WHERE gru_id=_id Limit 1;
        end if;
        if _key = '3' then
            SELECT `gru_id`, `gru_descripcion` FROM `grupos` WHERE gru_forum=_id Limit 1;
        end if;
        if _key = '4' then
            SELECT `gru_id`, `gru_descripcion` FROM `grupos` WHERE gru_forum= _id;
        end if;
          if _key = '5' then
            SELECT `gru_id`, `gru_descripcion` FROM `grupos`;
        end if;
         if _key = '6' then
            SELECT `gru_id`, `gru_descripcion` FROM `grupos` WHERE sede_id=_id;
        end if;
        if _key = '7' then
          SELECT gru_id, gru_descripcion from grupos where sede_id = (select sede_id from usuario where usu_id = _id); 
        end if; 
END;
