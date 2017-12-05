CREATE PROCEDURE `sp_updateStatus2017`(_codigo varchar(20), _fecha date)
BEGIN
declare v_id int;
declare v_valor double;
declare v_cant int;
declare v_total double;
select precobro_id, precobro_valor into v_id, v_valor from presupuestocobro where precobro_year = 2017 
and miembro_mie_id = fc_getMiembroByCodigo(_codigo) limit 1;

DELETE FROM `detallepresupuestocobro` WHERE presupuestocobro_precobro_id=v_id 
and detalleprecobro_fechavencimiento >= _fecha; 

select ifnull(count(*),0) from detallepresupuestocobro where presupuestocobro_precobro_id = v_id;

set v_total = v_cant * v_valor;

if v_cant = 0 then
        delete from presupuestocobro where precobro_id = v_id;
else 
        update presupuestocobro set precobro_total = v_total where precobro_id = v_id;
end if; 

END;
