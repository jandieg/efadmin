CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectTipoEventoAcotado`(IN `_id` INT)
BEGIN
    if _id <> '' then
        SELECT * FROM `tipo_evento` WHERE tip_eve_id=_id and tip_eve_id in (1,2,3,4,5);
    else
        SELECT * FROM `tipo_evento` where tip_eve_id in (1,2,3,4,5) order by tip_eve_orden;
    end if;
END;
