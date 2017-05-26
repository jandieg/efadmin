CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_cancelPresupuestoCobroMiembro`(_id_miembro int(11), _mes int(11), _anho int(11), _fecha Datetime)
BEGIN

update miembro set mie_fecha_cambio_status = _fecha where mie_id = _id_miembro;
delete from detallepresupuestocobro 
where year(detalleprecobro_fechavencimiento) >= _anho and 
month (detalleprecobro_fechavencimiento) > _mes and
presupuestocobro_precobro_id = (select precobro_id 
from presupuestocobro where miembro_mie_id = _id_miembro);

END;
