CREATE DEFINER=`root`@`%` PROCEDURE `sp_selectGrupoByUser`(_id_usuario int(11), _agrup varchar(10))
BEGIN
  DECLARE v_sede int;
  SELECT `sede_id` INTO v_sede FROM `usuario` WHERE `usu_id` = `_id_usuario`;
  IF `_agrup` = '' THEN
    SELECT * FROM `grupos` WHERE `sede_id` = v_sede;
  ELSE
    SELECT * FROM `grupos` WHERE `sede_id` = v_sede AND `agrup` IN (`_agrup`);
  END IF;
END;
