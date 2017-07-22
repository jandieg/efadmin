CREATE DEFINER=`root`@`%` PROCEDURE `sp_selectGruposAgrupExcluyendo`(_id_excluye int(11))
BEGIN
        select gru_id from grupos where gru_id not in (_id_excluye) and agrup in ('A');
END;
