CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectMembresiaByValor`(IN _valor double)
BEGIN
        select * from membresia where memb_valor = _valor; 
END;
