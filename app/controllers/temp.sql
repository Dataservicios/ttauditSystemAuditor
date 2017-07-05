DELIMITER $$

DROP PROCEDURE IF EXISTS `sp_consulta_reporte_company_28` $$
CREATE DEFINER=`root`@`%` PROCEDURE `sp_consulta_reporte_company_28`()
BEGIN
DROP TEMPORARY TABLE IF EXISTS tmp_comercios;
CREATE TEMPORARY TABLE IF NOT EXISTS tmp_comercios ( INDEX(store_id) ) AS
(
select * FROM comercio_excel_company_28
);


DROP TEMPORARY TABLE IF EXISTS tmp_sino;
CREATE TEMPORARY TABLE IF NOT EXISTS tmp_sino ( INDEX(company_id, store_id, poll_id) ) AS
(
select * FROM respuestas_sino_company_28
where store_id in (select store_id from tmp_comercios)
);


DROP TEMPORARY TABLE IF EXISTS tmp_opciones;
CREATE TEMPORARY TABLE IF NOT EXISTS tmp_opciones ( INDEX(store_id, poll_id ) ) AS
(
select a.poll_id, a.store_id, a.Respuesta, a.Foto, a.comentario, b.options, b.limite, b.otro
from tmp_sino a
left outer join respuestas_opciones_company_28 b
on (a.poll_id = b.poll_id and a.store_id = b.store_id)
where a.store_id in (select store_id from tmp_comercios)
);

DROP TEMPORARY TABLE IF EXISTS preg_379;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_379 ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
sum(case when options = '379a' then 1 else 0 end) as a,
sum(case when options = '379b' then 1 else 0 end) as b,
sum(case when options = '379d' then 1 else 0 end) as d
from tmp_opciones
where poll_id = 379
group by store_id, respuesta, foto
);

DROP TEMPORARY TABLE IF EXISTS preg_379_c_otro;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_379_c_otro ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
otro
from tmp_opciones
where poll_id = 379 and options ='379c'
group by store_id, respuesta
);

DROP TEMPORARY TABLE IF EXISTS preg_380;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_380 ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
sum(case when options = '380a' then 1 else 0 end) as a,
sum(case when options = '380b' then 1 else 0 end) as b,
sum(case when options = '380c' then 1 else 0 end) as c,
sum(case when options = '380d' then 1 else 0 end) as d
from tmp_opciones
where poll_id = 380
group by store_id, respuesta
);

DROP TEMPORARY TABLE IF EXISTS preg_381;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_381 ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
sum(case when options = '381a' then 1 else 0 end) as a,
sum(case when options = '381b' then 1 else 0 end) as b,
sum(case when options = '381c' then 1 else 0 end) as c,
sum(case when options = '381d' then 1 else 0 end) as d
from tmp_opciones
where poll_id = 381
group by store_id, respuesta
);


DROP TEMPORARY TABLE IF EXISTS preg_382;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_382 ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
sum(case when options = '382a' then 1 else 0 end) as a,
sum(case when options = '382b' then 1 else 0 end) as b,
sum(case when options = '382c' then 1 else 0 end) as c,
sum(case when options = '382d' then 1 else 0 end) as d,
sum(case when options = '382e' then 1 else 0 end) as e,
sum(case when options = '382f' then 1 else 0 end) as f,
sum(case when options = '382g' then 1 else 0 end) as g,
sum(case when options = '382h' then 1 else 0 end) as h,
sum(case when options = '382i' then 1 else 0 end) as i,
sum(case when options = '382j' then 1 else 0 end) as j,
sum(case when options = '382k' then 1 else 0 end) as k,
sum(case when options = '382l' then 1 else 0 end) as l,
sum(case when options = '382m' then 1 else 0 end) as m,
sum(case when options = '382n' then 1 else 0 end) as n,
sum(case when options = '382o' then 1 else 0 end) as o
from tmp_opciones
where poll_id = 382
group by store_id, respuesta
);

DROP TEMPORARY TABLE IF EXISTS preg_383;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_383 ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
sum(case when options = '383a' then 1 else 0 end) as a,
sum(case when options = '383b' then 1 else 0 end) as b,
sum(case when options = '383c' then 1 else 0 end) as c,
sum(case when options = '383e' then 1 else 0 end) as e,
sum(case when options = '383f' then 1 else 0 end) as f,
sum(case when options = '383g' then 1 else 0 end) as g
from tmp_opciones
where poll_id = 383
group by store_id, respuesta
);


DROP TEMPORARY TABLE IF EXISTS preg_384;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_384 ( INDEX(store_id ) ) AS
(
select * from tmp_sino where poll_id = 384
);


select
tmp_comercios.store_id,
tmp_comercios.cadenaRuc,
tmp_comercios.encuestado,
tmp_comercios.district,
tmp_comercios.punto,
tmp_comercios.tipo_bodega,
tmp_comercios.auditor_id,
tmp_comercios.auditor,
tmp_comercios.fecha,
tmp_comercios.hora,
tmp_comercios.Foto,
(case when preg_379.a > 0 then 2 else preg_379.a end) as '379_a',
(case when preg_379.b > 0 then 2 else preg_379.b end) as '379_b',
(case when preg_379.d > 0 then 2 else preg_379.d end) as '379_d',
preg_379_c_otro.otro as '379_c_otro',
(case when preg_380.a > 0 then 2 else preg_380.a end) as '380_a',
(case when preg_380.b > 0 then 2 else preg_380.b end) as '380_b',
(case when preg_380.c > 0 then 2 else preg_380.c end) as '380_c',
(case when preg_380.d > 0 then 2 else preg_380.d end) as '380_d',
(case when preg_381.Respuesta > 0 then 2 else preg_381.Respuesta end) as '381_Respuesta'
(case when preg_381.a > 0 then 2 else preg_381.a end) as '381_a',
(case when preg_381.b > 0 then 2 else preg_381.b end) as '381_b',
(case when preg_381.c > 0 then 2 else preg_381.c end) as '381_c',
(case when preg_381.d > 0 then 2 else preg_381.d end) as '381_d',
(case when preg_382.a > 0 then 2 else preg_382.a end) as '382_a',
(case when preg_382.b > 0 then 2 else preg_382.b end) as '382_b',
(case when preg_382.c > 0 then 2 else preg_382.c end) as '382_c',
(case when preg_382.d > 0 then 2 else preg_382.c end) as '382_d',
(case when preg_382.e > 0 then 2 else preg_382.c end) as '382_e',
(case when preg_382.f > 0 then 2 else preg_382.c end) as '382_f',
(case when preg_382.g > 0 then 2 else preg_382.c end) as '382_g',
(case when preg_382.h > 0 then 2 else preg_382.c end) as '382_h',
(case when preg_382.i > 0 then 2 else preg_382.c end) as '382_i',
(case when preg_382.j > 0 then 2 else preg_382.c end) as '382_j',
(case when preg_382.k > 0 then 2 else preg_382.c end) as '382_k',
(case when preg_382.l > 0 then 2 else preg_382.c end) as '382_l',
(case when preg_382.m > 0 then 2 else preg_382.c end) as '382_m',
(case when preg_382.n > 0 then 2 else preg_382.c end) as '382_n',
(case when preg_382.o > 0 then 2 else preg_382.c end) as '382_o',
(case when preg_383.Respuesta > 0 then 2 else preg_383.Respuesta end) as '383_Respuesta'
(case when preg_383.a > 0 then 2 else preg_383.a end) as '383_a',
(case when preg_383.b > 0 then 2 else preg_383.b end) as '383_b',
(case when preg_383.c > 0 then 2 else preg_383.c end) as '383_c',
(case when preg_383.e > 0 then 2 else preg_383.e end) as '383_e',
(case when preg_383.f > 0 then 2 else preg_383.f end) as '383_f',
(case when preg_383.g > 0 then 2 else preg_383.g end) as '383_g',
(case when preg_384.Respuesta > 0 then 2 else preg_384.Respuesta end) as '384_Respuesta'
from tmp_comercios
left outer join preg_379 on (tmp_comercios.store_id = preg_379.store_id )
left outer join preg_379_c_otro on (tmp_comercios.store_id = preg_379_c_otro.store_id )
left outer join preg_380 on (tmp_comercios.store_id = preg_380.store_id )
left outer join preg_381 on (tmp_comercios.store_id = preg_381.store_id )
left outer join preg_382 on (tmp_comercios.store_id = preg_382.store_id )
left outer join preg_383 on (tmp_comercios.store_id = preg_383.store_id )
left outer join preg_384 on (tmp_comercios.store_id = preg_384.store_id )
ORDER BY tmp_comercios.fecha Desc, tmp_comercios.hora DESC;

END $$

DELIMITER ;