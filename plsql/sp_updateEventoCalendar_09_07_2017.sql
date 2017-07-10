CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_updateEventoCalendar`(IN `_id` INT, IN `_responsable` VARCHAR(100), 
IN `_toeldia` INT, IN `_fi` TIMESTAMP, IN `_ff` TIMESTAMP, IN `_descripcion` VARCHAR(200), 
IN `_usuario` VARCHAR(10), IN `_lista_invitados` VARCHAR(250), IN `_lista_grupos` VARCHAR(250), 
IN `_lista_miembros` VARCHAR(250), IN `_miembrosGrupos` INT, IN `_todos_grupos` INT, 
IN `_id_direccion` VARCHAR(200), IN `_id_acompanado` INT, IN `_lista_contactos` VARCHAR(250), 
IN `_lista_empresarios_mes` VARCHAR(250), IN `_nombre` VARCHAR(100))
BEGIN

    UPDATE evento 
    SET eve_nombre=_nombre,eve_responsable=_responsable,eve_todoeldia=_toeldia,eve_fechainicio=_fi,eve_fechafin=_ff,
    eve_id_usuario=_usuario,direccion_id=_id_direccion,
    eve_descripcion=_descripcion,eve_mis_grupos=_lista_grupos,eve_todos_grupos=_todos_grupos 
    WHERE eve_id=_id;

    if _id_acompanado <> '' then
        UPDATE evento SET evento_acompanado=_id_acompanado  WHERE eve_id=_id;
    end if;

    DELETE FROM evento_miembro WHERE evento_eve_id = _id;
    if _lista_miembros <> '' then
        WHILE (LOCATE(',', _lista_miembros) > 0)
        DO
            SET @value = ELT(1, _lista_miembros);
            SET _lista_miembros= SUBSTRING(_lista_miembros, LOCATE(',',_lista_miembros) + 1);
            INSERT INTO evento_miembro( evento_eve_id, miembro_mie_id) VALUES (_id,@value);

        END WHILE;
    end if;


    if _lista_grupos <> '' then
        DELETE FROM evento_grupo WHERE evento_eve_id  = _id;
            INSERT INTO evento_grupo( evento_eve_id, grupos_gru_id) VALUES (_id,_lista_grupos);
    end if;


    DELETE FROM evento_participante WHERE evento_eve_id=_id and participante_part_id in (SELECT part_id  FROM participante WHERE part_tipo = 'Invitado');
    if _lista_invitados <> '' then
        WHILE (LOCATE(',', _lista_invitados) > 0)
        DO
            SET @value = ELT(1, _lista_invitados);
            SET _lista_invitados= SUBSTRING(_lista_invitados, LOCATE(',',_lista_invitados) + 1);

            INSERT INTO evento_participante( participante_part_id, evento_eve_id) VALUES (@value,_id);
        END WHILE;
    end if;


    DELETE FROM evento_participante WHERE evento_eve_id=_id and participante_part_id in (SELECT part_id  FROM participante WHERE part_tipo = 'Contacto');
     if _lista_contactos <> '' then
        WHILE (LOCATE(',', _lista_contactos) > 0)
        DO
            SET @value = ELT(1, _lista_contactos);
            SET _lista_contactos= SUBSTRING(_lista_contactos, LOCATE(',',_lista_contactos) + 1);

            INSERT INTO evento_participante( participante_part_id, evento_eve_id)  VALUES (@value,_id);
        END WHILE;
    end if;
    
    DELETE FROM evento_empresario_mes WHERE evento_eve_id = _id;
    if _lista_empresarios_mes <> '' then
        WHILE (LOCATE(',', _lista_empresarios_mes) > 0)
        DO
            SET @value = ELT(1, _lista_empresarios_mes);
            SET _lista_empresarios_mes= SUBSTRING(_lista_empresarios_mes, LOCATE(',',_lista_empresarios_mes) + 1);

             INSERT INTO evento_empresario_mes( miembro_mie_id, evento_eve_id, eve_emp_estado, eve_emp_id_usuario)
             VALUES (@value,_id,'1',_usuario);
          
        END WHILE;
    end if;
END;
