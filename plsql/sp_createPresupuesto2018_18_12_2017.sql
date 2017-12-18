CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_createPresupuesto2018`(IN `_id_miembro` INT, IN `_valor` DOUBLE)
BEGIN
declare v_total double;
declare v_id int;
set v_total = _valor*12;
insert into presupuestocobro (precobro_valor, precobro_fechainiciomiembro, 
miembro_mie_id, precobro_total, periodo_perio_id, precobro_fecharegistro,
precobroi_fechamodificacion, precobro_id_usuario, precobro_year) values
(_valor, '2018-01-01 00:00:00', _id_miembro, v_total, 1, '2018-01-01 00:00:05',
'2018-01-01 00:00:05',1,2018);
set v_id = last_insert_id();

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuestocobro_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2018-01-01', v_id, 1, 1);

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuestocobro_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2018-02-01', v_id, 1, 1);

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuestocobro_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2018-03-01', v_id, 1, 1);

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuestocobro_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2018-04-01', v_id, 1, 1);

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuestocobro_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2018-05-01', v_id, 1, 1);

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuestocobro_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2018-06-01', v_id, 1, 1);

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuestocobro_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2018-07-01', v_id, 1, 1);

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuestocobro_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2018-08-01', v_id, 1, 1);

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuestocobro_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2018-09-01', v_id, 1, 1);

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuestocobro_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2018-10-01', v_id, 1, 1);

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuestocobro_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2018-11-01', v_id, 1, 1);

insert into detallepresupuestocobro (detalleprecobro_valor, detalleprecobro_fechavencimiento,
presupuestocobro_precobro_id, estado_presupuesto_est_pre_id, tipo_presupusto_id)
values (_valor, '2018-12-01', v_id, 1, 1);

END;
