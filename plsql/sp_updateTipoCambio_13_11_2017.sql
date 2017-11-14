CREATE DEFINER=`root`@`%` PROCEDURE `sp_updateTipoCambio`(_mes int(11), _anho int(11), _sede int(11), _cambio float, _moneda varchar(10))
BEGIN
declare v_id int;
select id into v_id from tipo_cambio where mes = _mes and anho = _anho and sede_id = _sede;

if v_id is not null then
        update tipo_cambio set cambio = _cambio, moneda= _moneda where id = v_id;
else 
        insert into tipo_cambio (id, anho, mes, sede_id, cambio, moneda) 
        values (NULL, _anho, _mes, _sede, _cambio, _moneda);
end if;
END;