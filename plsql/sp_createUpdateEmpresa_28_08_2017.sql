CREATE DEFINER='execforums'@'localhost' PROCEDURE `sp_createUpdateEmpresa`(IN _emp_nombre varchar(100),IN _id_industria int(11))
BEGIN
declare v_id int;
declare v_lid_id int;
select emp_id into v_id from empresalocal where emp_nombre in (_emp_nombre);
if v_id is null then 
   insert into empresalocal (emp_nombre, emp_fecharegistro, 
   emp_fechamodificacion, emp_id_usuario, emp_estado) 
   values (_emp_nombre, now(), now(), 1, 'A');
   set v_lid_id = last_insert_id();
   insert into empresa_industria (emp_ind_estado, empresalocal_emp_id, industria_ind_id) 
   values ('A', v_lid_id, _id_industria);
end if;
END;