CREATE DEFINER=execforums@localhost PROCEDURE `sp_selectMiembroByCodigo`(_codigo varchar(11))
BEGIN
select * from miembro where mie_codigo in (_codigo);
END;