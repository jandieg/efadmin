BEGIN
UPDATE
correo c join miembro m on c.persona_per_id=m.persona_per_id 
SET m.secret=_code
WHERE c.cor_descripcion=_mail;

select m.mie_id as id,p.per_nombre as name,
(select t.tel_descripcion from telefono t where t.persona_per_id=m.persona_per_id and t.tel_tipo='M' limit 1 ) as cel,
(select cor.cor_descripcion from usuario usu join correo cor on (cor.Persona_per_id = usu.Persona_per_id) where usu.perfil_per_id = 2 and
usu.sede_id = (select sede_id from grupos where gru_id = m.grupo_id limit 1) limit 1) as correo_ibp2, 
(select cor.cor_descripcion from usuario usu join correo cor on (cor.Persona_per_id = usu.Persona_per_id) where usu.perfil_per_id = 19 and
usu.sede_id = (select sede_id from grupos where gru_id = m.grupo_id limit 1) limit 1) as correo_ibp
from correo c join miembro m on c.persona_per_id=m.persona_per_id 
join persona p on p.per_id=m.persona_per_id
WHERE c.cor_descripcion=_mail;
END