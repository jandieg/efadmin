CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectProspecto1`(IN `_id_prospecto` INT)
BEGIN

    SELECT   
    persona.per_id ,  
    persona.per_nombre, 
    persona.per_apellido, 
    persona.per_tipo, 
    case persona.per_tipo
            when 'J' then 'Jurídica'
            when 'N' then 'Natural'
    end persona_tipo,
    persona.per_identificacion, 
    persona.per_fechanacimiento,  
    case persona.per_genero
            when 'M' then 'MASCULINO'
            when 'f' then 'FEMENINO'
    end per_genero, 
prospecto.prosp_fechacambioforum,
prospecto.prosp_txtadicional,
    prospecto.pro_id as '_id_prospecto',
    prospecto.prosp_codigo,
    prospecto.prosp_fechamodificacion, 
    prospecto.prosp_fecharegistro, 
    prospecto.prosp_usu_id, 
    prospecto.participacion_correo,
    prospecto.prosp_observacion,
    prospecto.fuente_fue_id,
    prospecto.prosp_empresa,
    fuente.fue_descripcion,
    prospecto.forum_usu_id,
    prospecto.categoria_cat_id,
    prospecto.estadoprospecto_estpro_id,
    estadoprospecto.estpro_descripcion,
    prospecto.Profesion_prof_id,
	prospecto.prosp_esaplicanteesmiembro,
        prospecto.prosp_esprospectoaplicante,
        prospecto.prospecto_id,
    prospecto.prosp_esaplicante,
    prospecto.status_member_id, 
    prospecto.prosp_observacion,
    prospecto.empresalocal_emp_id,
        case prospecto.prosp_aprobado when '0' then 'NO'
            when '1' then 'SI'
    end prosp_aprobado,
    (SELECT concat (member_status.mem_sta_codigo , ' - ', member_status.mem_sta_descripcion) FROM member_status 
        WHERE member_status.mem_sta_id = prospecto.status_member_id ) as 'status',
    profesion.prof_descripcion, 
    prospecto.categoria_cat_id,
    categoria.cat_descripcion,
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) 
                     FROM persona, perfil, usuario WHERE usuario.usu_id= prospecto.forum_usu_id 
                     and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum',
            (SELECT  cor_descripcion  FROM correo WHERE Persona_per_id=persona.per_id and cor_tipo = 'Personal' LIMIT 1) as 'correo',
            (SELECT  tel_descripcion FROM telefono WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  cor_descripcion  FROM correo WHERE Persona_per_id=persona.per_id and cor_tipo = 'Secundario' LIMIT 1) as 'correo2',
            (SELECT  tel_descripcion FROM telefono WHERE Persona_per_id=persona.per_id and tel_tipo= 'C' LIMIT 1 ) as 'movil2',
            (SELECT  red_descripcion  FROM redsocial_prospecto WHERE Binary red_tipo= 'skype' and prospecto_pro_id= prospecto.pro_id) as 'skype',
            (SELECT  red_descripcion  FROM redsocial_prospecto WHERE Binary red_tipo= 'twitter' and prospecto_pro_id= prospecto.pro_id) as 'twitter',
            (SELECT concat( persona.per_nombre,' ', persona.per_apellido)  FROM usuario join persona on usuario.Persona_per_id  = persona.per_id 
                    WHERE usuario.usu_id= prospecto.prosp_usu_id and usuario.usu_estado = 'A') as 'modificador',
                    empresalocal.emp_id, 
empresalocal.emp_nombre, 
empresalocal.emp_ruc, 
empresalocal.emp_imgresos, 
empresalocal.emp_num_empleados, 
empresalocal.emp_fax, 
empresalocal.emp_sitio_web
    FROM prospecto  
    INNER join persona on prospecto.Persona_per_id = persona.per_id
    left join fuente on prospecto.fuente_fue_id = fuente.fue_id
    left join estadoprospecto on prospecto.estadoprospecto_estpro_id = estadoprospecto.estpro_id
    left join categoria on prospecto.categoria_cat_id = categoria.cat_id
    left join profesion on prospecto.Profesion_prof_id = profesion.prof_id 
    Left join empresalocal on prospecto.empresalocal_emp_id = empresalocal.emp_id 
    where prospecto.pro_id= _id_prospecto;
   
   
END;
