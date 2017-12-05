CREATE FUNCTION `fc_getMiembroByCodigo`(_codigo varchar(20)) RETURNS int(11)
BEGIN
  declare v_id int;
   select mie_id into v_id from miembro where mie_codigo in (_codigo) limit 1;
  RETURN v_id;
END;
