CREATE PROCEDURE `sp_selectCredencialesUsuario`(_user_id int(11))
BEGIN
select usuario.usu_user, substr(usuario.usu_pass, 1,6) as codigo, correo.cor_descripcion 
from usuario join correo on usuario.Persona_per_id = correo.Persona_per_id 
where usuario.usu_id = _user_id; 
END;
