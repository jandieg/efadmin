CREATE DEFINER=`root`@`%` FUNCTION `fc_getFlGrupoByDesc`(_desc varchar(11)) RETURNS int(11)
BEGIN
declare v_id int;
select gru_forum into v_id from grupos where gru_descripcion in (_desc);
if v_id is null then 
return 1;
else 
return v_id;
end if;
  RETURN 1;
END;
