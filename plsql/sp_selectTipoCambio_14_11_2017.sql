CREATE DEFINER=`root`@`%` PROCEDURE `sp_selectTipoCambio`(_year int(11), _id_usuario int(11))
BEGIN
select tc.moneda, tc.mes, tc.cambio, sd.sede_razonsocial, sd.sede_id 
from sede sd left join tipo_cambio tc on (tc.sede_id = sd.sede_id and tc.anho = _year) 
where  
sd.sede_id = (select sede_id from usuario where usu_id = _id_usuario);
END;
