INSERT INTO sgr.entidad ( id_entidad, id_rubro, razonsocial, cuit, fbaja, propietario ) VALUES (1, 49, 'LONDON FREE ZONE SA','30711370141',DEFAULT,'TRUE');
INSERT INTO sgr.entidad ( id_entidad, id_rubro, razonsocial, cuit, fbaja, propietario ) VALUES (2, 22, 'DFS','30707036938',DEFAULT,'TRUE');
INSERT INTO sgr.entidad ( id_entidad, id_rubro, razonsocial, cuit, fbaja, propietario ) VALUES (3, 49, 'SHOPPING A','31724561201',DEFAULT,'FALSE');

SELECT setval('sgr.entidad_id_entidad_seq', 4);