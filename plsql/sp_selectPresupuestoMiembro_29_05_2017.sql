CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectPresupuestoMiembro`(IN _id_presupuesto int(11))
BEGIN
select presupuestocobro.precobro_valor, periodo.perio_descripcion 
from presupuestocobro  
join periodo  
on (presupuestocobro.periodo_perio_id=periodo.perio_id)
where presupuestocobro.precobro_id = _id_presupuesto; 
END;
