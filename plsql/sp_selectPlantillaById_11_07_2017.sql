CREATE DEFINER=execforums@localhost PROCEDURE `sp_selectPlantillaById`(_id_plantilla int(11))
BEGIN
select * from plantillas_email where plantilla_id = _id_plantilla;
END;
