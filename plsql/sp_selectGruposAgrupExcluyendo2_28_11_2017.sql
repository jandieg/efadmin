CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectGruposAgrupExcluyendo2`(IN `_id_excluye` INT)
BEGIN
        select gru_id from grupos where gru_id not in (_id_excluye) and sede_id = (select sede_id from grupos where gru_id = _id_excluye);
END;
