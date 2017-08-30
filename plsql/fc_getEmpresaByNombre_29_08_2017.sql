CREATE DEFINER='execforums'@'localhost' FUNCTION `fc_getEmpresaByNombre`(_nombre varchar(100)) RETURNS int(11)
BEGIN
declare v_id int;
select emp_id into v_id from empresalocal where emp_nombre in (_nombre);
  RETURN v_id;
END;
