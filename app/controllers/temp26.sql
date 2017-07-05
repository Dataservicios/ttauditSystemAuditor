DELIMITER $$

DROP PROCEDURE IF EXISTS `sp_consulta_reporte_company_26` $$
CREATE DEFINER=`root`@`%` PROCEDURE `sp_consulta_reporte_company_26`()
BEGIN
DROP TEMPORARY TABLE IF EXISTS tmp_comercios;
CREATE TEMPORARY TABLE IF NOT EXISTS tmp_comercios ( INDEX(store_id) ) AS
(
select * FROM comercio_excel_company_26
);


DROP TEMPORARY TABLE IF EXISTS tmp_sino;
CREATE TEMPORARY TABLE IF NOT EXISTS tmp_sino ( INDEX(company_id, store_id, poll_id) ) AS
(
select * FROM respuestas_sino_company_26
where store_id in (select store_id from tmp_comercios)
);


DROP TEMPORARY TABLE IF EXISTS tmp_opciones;
CREATE TEMPORARY TABLE IF NOT EXISTS tmp_opciones ( INDEX(store_id, poll_id ) ) AS
(
select a.poll_id, a.store_id, a.Respuesta, a.Foto, a.comentario, b.options, b.limite, b.otro
from tmp_sino a
left outer join respuestas_opciones_company_26 b
on (a.poll_id = b.poll_id and a.store_id = b.store_id)
where a.store_id in (select store_id from tmp_comercios)
);


DROP TEMPORARY TABLE IF EXISTS preg_349;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_349 ( INDEX(store_id ) ) AS
(
select * from tmp_sino where poll_id = 349
);


DROP TEMPORARY TABLE IF EXISTS preg_350;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_350 ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
sum(case when options = '350a' then 1 else 0 end) as a,
sum(case when options = '350b' then 1 else 0 end) as b,
sum(case when options = '350c' then 1 else 0 end) as c,
sum(case when options = '350d' then 1 else 0 end) as d,
sum(case when options = '350e' then 1 else 0 end) as e,
foto
from tmp_opciones
where poll_id = 350
group by store_id, respuesta, foto
);

DROP TEMPORARY TABLE IF EXISTS preg_350_f_otro;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_350_f_otro ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
otro
from tmp_opciones
where poll_id = 350 and options ='350f'
group by store_id, respuesta
);

DROP TEMPORARY TABLE IF EXISTS preg_351;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_351 ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
sum(case when options = '351a' then 1 else 0 end) as a,
sum(case when options = '351b' then 1 else 0 end) as b,
sum(case when options = '351c' then 1 else 0 end) as c,
foto
from tmp_opciones
where poll_id = 351
group by store_id, respuesta, foto
);

DROP TEMPORARY TABLE IF EXISTS preg_352;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_352 ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
sum(case when options = '352a' then 1 else 0 end) as a,
sum(case when options = '352b' then 1 else 0 end) as b,
sum(case when options = '352c' then 1 else 0 end) as c,
sum(case when options = '352d' then 1 else 0 end) as d,
sum(case when options = '352e' then 1 else 0 end) as e,
foto
from tmp_opciones
where poll_id = 352
group by store_id, respuesta, foto
);


DROP TEMPORARY TABLE IF EXISTS preg_353;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_353 ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
sum(case when options = '353a' then 1 else 0 end) as a,
sum(case when options = '353b' then 1 else 0 end) as b,
sum(case when options = '353c' then 1 else 0 end) as c,
foto
from tmp_opciones
where poll_id = 353
group by store_id, respuesta, foto
);


DROP TEMPORARY TABLE IF EXISTS preg_354;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_354 ( INDEX(store_id ) ) AS
(
select * from tmp_sino where poll_id = 354
);


DROP TEMPORARY TABLE IF EXISTS preg_355;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_355 ( INDEX(store_id ) ) AS
(
select * from tmp_sino where poll_id = 355
);


DROP TEMPORARY TABLE IF EXISTS preg_356;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_356 ( INDEX(store_id ) ) AS
(
select * from tmp_sino where poll_id = 356
);

DROP TEMPORARY TABLE IF EXISTS preg_357;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_357 ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
sum(case when options = '357a' then 1 else 0 end) as a,
sum(case when options = '357b' then 1 else 0 end) as b,
sum(case when options = '357c' then 1 else 0 end) as c,
sum(case when options = '357d' then 1 else 0 end) as d,
comentario,
foto,
limite
from tmp_opciones
where poll_id = 357
group by store_id, respuesta, foto, limite
);

DROP TEMPORARY TABLE IF EXISTS preg_358;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_358 ( INDEX(store_id ) ) AS
(
select * from tmp_sino where poll_id = 358
);


DROP TEMPORARY TABLE IF EXISTS preg_359;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_359 ( INDEX(store_id ) ) AS
(
select * from tmp_sino where poll_id = 359
);


DROP TEMPORARY TABLE IF EXISTS preg_360;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_360 ( INDEX(store_id ) ) AS
(
select * from tmp_sino where poll_id = 360
);


DROP TEMPORARY TABLE IF EXISTS preg_361;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_361 ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
sum(case when options = '361a' then 1 else 0 end) as a,
sum(case when options = '361b' then 1 else 0 end) as b,
sum(case when options = '361c' then 1 else 0 end) as c,
foto
from tmp_opciones
where poll_id = 361
group by store_id, respuesta, foto
);


DROP TEMPORARY TABLE IF EXISTS preg_362;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_362 ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
sum(case when options = '362a' then 1 else 0 end) as a,
sum(case when options = '362b' then 1 else 0 end) as b,
sum(case when options = '362c' then 1 else 0 end) as c,
foto
from tmp_opciones
where poll_id = 362
group by store_id, respuesta, foto
);


DROP TEMPORARY TABLE IF EXISTS preg_363;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_363 ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
sum(case when options = '363a' then 1 else 0 end) as a,
sum(case when options = '363b' then 1 else 0 end) as b,
foto
from tmp_opciones
where poll_id = 363
group by store_id, respuesta, foto
);


DROP TEMPORARY TABLE IF EXISTS preg_364;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_364 ( INDEX(store_id ) ) AS
(
select * from tmp_sino where poll_id = 364
);


DROP TEMPORARY TABLE IF EXISTS preg_365;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_365 ( INDEX(store_id ) ) AS
(
select * from tmp_sino where poll_id = 365
);


DROP TEMPORARY TABLE IF EXISTS preg_366;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_366 ( INDEX(store_id ) ) AS
(
select * from tmp_sino where poll_id = 366
);


DROP TEMPORARY TABLE IF EXISTS preg_367;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_367 ( INDEX(store_id ) ) AS
(
select * from tmp_sino where poll_id = 367
);


DROP TEMPORARY TABLE IF EXISTS preg_368;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_368 ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
sum(case when options = '368a' then 1 else 0 end) as a,
sum(case when options = '368b' then 1 else 0 end) as b,
sum(case when options = '368c' then 1 else 0 end) as c,
sum(case when options = '368d' then 1 else 0 end) as d,
sum(case when options = '368e' then 1 else 0 end) as e,
foto
from tmp_opciones
where poll_id = 368
group by store_id, respuesta, foto
);

DROP TEMPORARY TABLE IF EXISTS preg_368_f_otro;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_368_f_otro ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
otro
from tmp_opciones
where poll_id = 368 and options ='368f'
group by store_id, respuesta
);

DROP TEMPORARY TABLE IF EXISTS preg_369;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_369 ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
sum(case when options = '369a' then 1 else 0 end) as a,
sum(case when options = '369b' then 1 else 0 end) as b,
sum(case when options = '369c' then 1 else 0 end) as c,
foto,
limite
from tmp_opciones
where poll_id = 369
group by store_id, respuesta, foto, limite
);

DROP TEMPORARY TABLE IF EXISTS preg_369_d_otro;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_369_d_otro ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
otro
from tmp_opciones
where poll_id = 369 and options ='369d'
group by store_id, respuesta
);

DROP TEMPORARY TABLE IF EXISTS preg_370;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_370 ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
sum(case when options = '370a' then 1 else 0 end) as a,
sum(case when options = '370b' then 1 else 0 end) as b,
sum(case when options = '370c' then 1 else 0 end) as c,
sum(case when options = '370d' then 1 else 0 end) as d,
foto,
limite
from tmp_opciones
where poll_id = 370
group by store_id, respuesta, foto, limite
);

DROP TEMPORARY TABLE IF EXISTS preg_370_b_otro;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_370_b_otro ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
otro
from tmp_opciones
where poll_id = 370 and options ='370b'
group by store_id, respuesta
);

DROP TEMPORARY TABLE IF EXISTS preg_371;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_371 ( INDEX(store_id ) ) AS
(
select * from tmp_sino where poll_id = 371
);


DROP TEMPORARY TABLE IF EXISTS preg_372;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_372 ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
sum(case when options = '372a' then 1 else 0 end) as a,
sum(case when options = '372b' then 1 else 0 end) as b,
sum(case when options = '372c' then 1 else 0 end) as c,
sum(case when options = '372d' then 1 else 0 end) as d,
sum(case when options = '372e' then 1 else 0 end) as e,
sum(case when options = '372f' then 1 else 0 end) as f,
sum(case when options = '372g' then 1 else 0 end) as g,
foto,
limite
from tmp_opciones
where poll_id = 372
group by store_id, respuesta, foto, limite
);

DROP TEMPORARY TABLE IF EXISTS preg_373;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_373 ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
sum(case when options = '373a' then 1 else 0 end) as a,
sum(case when options = '373b' then 1 else 0 end) as b,
sum(case when options = '373c' then 1 else 0 end) as c,
sum(case when options = '373d' then 1 else 0 end) as d,
foto,
limite
from tmp_opciones
where poll_id = 373
group by store_id, respuesta, foto, limite
);


DROP TEMPORARY TABLE IF EXISTS preg_374;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_374 ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
sum(case when options = '374a' then 1 else 0 end) as a,
sum(case when options = '374b' then 1 else 0 end) as b,
sum(case when options = '374c' then 1 else 0 end) as c,
foto,
limite
from tmp_opciones
where poll_id = 374
group by store_id, respuesta, foto, limite
);


DROP TEMPORARY TABLE IF EXISTS preg_375;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_375 ( INDEX(store_id ) ) AS
(
select store_id,
respuesta,
sum(case when options = '375a' then 1 else 0 end) as a,
sum(case when options = '375b' then 1 else 0 end) as b,
sum(case when options = '375c' then 1 else 0 end) as c,
sum(case when options = '375d' then 1 else 0 end) as d,
sum(case when options = '375e' then 1 else 0 end) as e,
sum(case when options = '375f' then 1 else 0 end) as f,
sum(case when options = '375g' then 1 else 0 end) as g,
sum(case when options = '375h' then 1 else 0 end) as h,
sum(case when options = '375i' then 1 else 0 end) as i,
foto,
limite
from tmp_opciones
where poll_id = 375
group by store_id, respuesta, foto, limite
);


DROP TEMPORARY TABLE IF EXISTS preg_376;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_376 ( INDEX(store_id ) ) AS
(
select * from tmp_sino where poll_id = 376
);


DROP TEMPORARY TABLE IF EXISTS preg_377;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_377 ( INDEX(store_id ) ) AS
(
select * from tmp_sino where poll_id = 377
);


DROP TEMPORARY TABLE IF EXISTS preg_378;
CREATE TEMPORARY TABLE IF NOT EXISTS preg_378 ( INDEX(store_id ) ) AS
(
select * from tmp_sino where poll_id = 378
);



select
tmp_comercios.store_id,
tmp_comercios.codclient,
tmp_comercios.fullname,
tmp_comercios.address,
tmp_comercios.district,
tmp_comercios.region,
tmp_comercios.ubigeo,
tmp_comercios.latitude,
tmp_comercios.longitude,
tmp_comercios.ejecutivo,
tmp_comercios.coordinador,
tmp_comercios.fecha,
tmp_comercios.hora,
tmp_comercios.auditor,
(case when preg_349.Respuesta > 0 then 2 else preg_349.Respuesta end) as '349_Respuesta',
preg_349.Comentario as '349_Comentario',
(case when preg_352.Respuesta > 0 then 2 else preg_352.Respuesta end) as '352_Respuesta',
(case when preg_352.a > 0 then 2 else preg_352.a end) as '352_a',
(case when preg_352.b > 0 then 2 else preg_352.b end) as '352_b',
(case when preg_352.c > 0 then 2 else preg_352.c end) as '352_c',
(case when preg_352.d > 0 then 2 else preg_352.d end) as '352_d',
(case when preg_352.e > 0 then 2 else preg_352.e end) as '352_e',
preg_352.Foto as '352_Foto',
(case when preg_353.Respuesta > 0 then 2 else preg_353.Respuesta end) as '353_Respuesta',
(case when preg_353.a > 0 then 2 else preg_353.a end) as '353_a',
(case when preg_353.b > 0 then 2 else preg_353.b end) as '353_b',
(case when preg_353.c > 0 then 2 else preg_353.c end) as '353_c',
preg_353.Foto as '353_Foto',
(case when preg_354.Respuesta > 0 then 2 else preg_354.Respuesta end) as '354_Respuesta',
preg_354.comentario as '354_comentario',
(case when preg_355.Respuesta > 0 then 2 else preg_355.Respuesta end) as '355_Respuesta',
preg_355.comentario as '355_comentario',
(case when preg_356.Respuesta > 0 then 2 else preg_356.Respuesta end) as '356_Respuesta',
(case when preg_359.Respuesta > 0 then 2 else preg_359.Respuesta end) as '359_Respuesta',
(case when preg_360.Respuesta > 0 then 2 else preg_360.Respuesta end) as '360_Respuesta',
(case when preg_361.a > 0 then 2 else preg_361.a end) as '361_a',
(case when preg_361.b > 0 then 2 else preg_361.b end) as '361_b',
(case when preg_361.c > 0 then 2 else preg_361.c end) as '361_c',
(case when preg_362.a > 0 then 2 else preg_362.a end) as '362_a',
(case when preg_362.b > 0 then 2 else preg_362.b end) as '362_b',
(case when preg_362.c > 0 then 2 else preg_362.c end) as '362_c',
(case when preg_363.a > 0 then 2 else preg_363.a end) as '363_a',
(case when preg_363.b > 0 then 2 else preg_363.b end) as '363_b',
(case when preg_364.Respuesta > 0 then 2 else preg_364.Respuesta end) as '364_Respuesta',
preg_365.Opcion as '365_Opcion',
(case when preg_366.Respuesta > 0 then 2 else preg_366.Respuesta end) as '366_Respuesta',
(case when preg_367.Respuesta > 0 then 2 else preg_367.Respuesta end) as '367_Respuesta',
preg_367.Foto as '367_Foto',
(case when preg_368.a > 0 then 2 else preg_368.a end) as '368_a',
(case when preg_368.b > 0 then 2 else preg_368.b end) as '368_b',
(case when preg_368.c > 0 then 2 else preg_368.c end) as '368_c',
(case when preg_368.d > 0 then 2 else preg_368.d end) as '368_d',
(case when preg_368.e > 0 then 2 else preg_368.e end) as '368_e',
preg_368_f_otro.otro as '368_f_otro',
(case when preg_372.a > 0 then 2 else preg_372.a end) as '372_a',
(case when preg_372.b > 0 then 2 else preg_372.b end) as '372_b',
(case when preg_372.c > 0 then 2 else preg_372.c end) as '372_c',
(case when preg_372.d > 0 then 2 else preg_372.d end) as '372_d',
(case when preg_372.e > 0 then 2 else preg_372.e end) as '372_e',
(case when preg_372.f > 0 then 2 else preg_372.f end) as '372_f',
(case when preg_372.g > 0 then 2 else preg_372.g end) as '372_g',
preg_372.limite as '372_Opcion',
(case when preg_373.a > 0 then 2 else preg_373.a end) as '373_a',
(case when preg_373.b > 0 then 2 else preg_373.b end) as '373_b',
(case when preg_373.c > 0 then 2 else preg_373.c end) as '373_c',
(case when preg_373.d > 0 then 2 else preg_373.d end) as '373_d',
preg_373.limite as '373_Opcion',
(case when preg_374.a > 0 then 2 else preg_374.a end) as '374_a',
(case when preg_374.b > 0 then 2 else preg_374.b end) as '374_b',
(case when preg_374.c > 0 then 2 else preg_374.c end) as '374_c',
preg_374.limite as '374_Opcion',
(case when preg_375.Respuesta > 0 then 2 else preg_375.Respuesta end) as '375_Respuesta',
(case when preg_375.a > 0 then 2 else preg_375.a end) as '375_a',
(case when preg_375.b > 0 then 2 else preg_375.b end) as '375_b',
(case when preg_375.c > 0 then 2 else preg_375.c end) as '375_c',
(case when preg_375.d > 0 then 2 else preg_375.d end) as '375_d',
(case when preg_375.e > 0 then 2 else preg_375.e end) as '375_e',
(case when preg_375.f > 0 then 2 else preg_375.f end) as '375_f',
(case when preg_375.g > 0 then 2 else preg_375.g end) as '375_g',
(case when preg_375.h > 0 then 2 else preg_375.h end) as '375_h',
(case when preg_375.i > 0 then 2 else preg_375.i end) as '375_i',
(case when preg_376.Respuesta > 0 then 2 else preg_376.Respuesta end) as '376_Respuesta',
(case when preg_377.Respuesta > 0 then 2 else preg_377.Respuesta end) as '377_Respuesta',
preg_378.comentario as '378_comentario',
(case when preg_357.a > 0 then 2 else preg_357.a end) as '357_a',
(case when preg_357.b > 0 then 2 else preg_357.b end) as '357_b',
(case when preg_357.c > 0 then 2 else preg_357.c end) as '357_c',
(case when preg_357.d > 0 then 2 else preg_357.d end) as '357_d',
(case when preg_369.a > 0 then 2 else preg_369.a end) as '369_a',
(case when preg_369.b > 0 then 2 else preg_369.b end) as '369_b',
(case when preg_369.c > 0 then 2 else preg_369.c end) as '369_c',
preg_369_d_otro.otro as '369_d_otro',
(case when preg_350.a > 0 then 2 else preg_350.a end) as '350_a',
(case when preg_350.b > 0 then 2 else preg_350.b end) as '350_b',
(case when preg_350.c > 0 then 2 else preg_350.c end) as '350_c',
(case when preg_350.d > 0 then 2 else preg_350.d end) as '350_d',
(case when preg_350.e > 0 then 2 else preg_350.e end) as '350_e',
preg_350_f_otro.otro as '350_f_otro',
(case when preg_351.Respuesta > 0 then 2 else preg_351.Respuesta end) as '351_Respuesta',
(case when preg_351.a > 0 then 2 else preg_351.a end) as '351_a',
(case when preg_351.b > 0 then 2 else preg_351.b end) as '351_b',
(case when preg_351.c > 0 then 2 else preg_351.c end) as '351_c',
preg_351.foto as '351_Foto',
(case when preg_370.a > 0 then 2 else preg_370.a end) as '370_a',
(case when preg_370.b > 0 then 2 else preg_370.b end) as '370_b',
preg_370_b_otro.otro as '370_b_otro',
(case when preg_370.c > 0 then 2 else preg_370.c end) as '370_c',
(case when preg_370.d > 0 then 2 else preg_370.d end) as '370_d',
(case when preg_358.Respuesta > 0 then 2 else preg_358.Respuesta end) as '358_Respuesta',
(case when preg_371.Respuesta > 0 then 2 else preg_371.Respuesta end) as '371_Respuesta'
from tmp_comercios
left outer join preg_349 on (tmp_comercios.store_id = preg_349.store_id )
left outer join preg_352 on (tmp_comercios.store_id = preg_352.store_id )
left outer join preg_353 on (tmp_comercios.store_id = preg_353.store_id )
left outer join preg_354 on (tmp_comercios.store_id = preg_354.store_id )
left outer join preg_355 on (tmp_comercios.store_id = preg_355.store_id )
left outer join preg_356 on (tmp_comercios.store_id = preg_356.store_id )
left outer join preg_359 on (tmp_comercios.store_id = preg_359.store_id )
left outer join preg_360 on (tmp_comercios.store_id = preg_360.store_id )
left outer join preg_361 on (tmp_comercios.store_id = preg_361.store_id )
left outer join preg_362 on (tmp_comercios.store_id = preg_362.store_id )
left outer join preg_363 on (tmp_comercios.store_id = preg_363.store_id )
left outer join preg_364 on (tmp_comercios.store_id = preg_364.store_id )
left outer join preg_365 on (tmp_comercios.store_id = preg_365.store_id )
left outer join preg_366 on (tmp_comercios.store_id = preg_366.store_id )
left outer join preg_367 on (tmp_comercios.store_id = preg_367.store_id )
left outer join preg_368 on (tmp_comercios.store_id = preg_368.store_id )
left outer join preg_368_f_otro on (tmp_comercios.store_id = preg_368_f_otro.store_id )
left outer join preg_372 on (tmp_comercios.store_id = preg_372.store_id )
left outer join preg_373 on (tmp_comercios.store_id = preg_373.store_id )
left outer join preg_374 on (tmp_comercios.store_id = preg_374.store_id )
left outer join preg_375 on (tmp_comercios.store_id = preg_375.store_id )
left outer join preg_376 on (tmp_comercios.store_id = preg_376.store_id )
left outer join preg_377 on (tmp_comercios.store_id = preg_377.store_id )
left outer join preg_378 on (tmp_comercios.store_id = preg_378.store_id )
left outer join preg_357 on (tmp_comercios.store_id = preg_357.store_id )
left outer join preg_369 on (tmp_comercios.store_id = preg_369.store_id )
left outer join preg_369_d_otro on (tmp_comercios.store_id = preg_369_d_otro.store_id )
left outer join preg_350 on (tmp_comercios.store_id = preg_350.store_id )
left outer join preg_350_f_otro on (tmp_comercios.store_id = preg_350_f_otro.store_id )
left outer join preg_351 on (tmp_comercios.store_id = preg_351.store_id )
left outer join preg_370 on (tmp_comercios.store_id = preg_370.store_id )
left outer join preg_370_b_otro on (tmp_comercios.store_id = preg_370_b_otro.store_id )
left outer join preg_358 on (tmp_comercios.store_id = preg_358.store_id )
left outer join preg_371 on (tmp_comercios.store_id = preg_371.store_id )
ORDER BY tmp_comercios.fecha Desc, tmp_comercios.hora DESC;
END $$

DELIMITER ;