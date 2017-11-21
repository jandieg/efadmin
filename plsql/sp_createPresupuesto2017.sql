CREATE PROCEDURE `sp_createPresupuesto2017`(_id_miembro int(50), _valor double)
BEGIN
declare v_total double;
declare v_id int;
set v_total = _valor*12;
insert into presupuestocobro (precobro_valor, precobro_fechainiciomiembro, 
miembro_mie_id, precobro_total, periodo_perio_id, precobro_fecharegistro,
precobroi_fechamodificacion, precobro_id_usuario, precobro_year) values
(_valor, '2017-01-01 00:00:00', _id_miembro, v_total, 1, '2017-01-01 00:00:05',
'2017-01-01 00:00:05',1,2017);
 set v_id = last_insert_id();

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuesto_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2017-01-01', v_id, 1, 1);

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuesto_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2017-02-01', v_id, 1, 1);

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuesto_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2017-03-01', v_id, 1, 1);


insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuesto_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2017-04-01', v_id, 1, 1);

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuesto_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2017-05-01', v_id, 1, 1);

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuesto_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2017-06-01', v_id, 1, 1);

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuesto_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2017-07-01', v_id, 1, 1);

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuesto_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2017-08-01', v_id, 1, 1);

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuesto_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2017-09-01', v_id, 1, 1);

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuesto_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2017-10-01', v_id, 1, 1);

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuesto_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2017-11-01', v_id, 1, 1);

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuesto_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2017-12-01', v_id, 1, 1);

END;
