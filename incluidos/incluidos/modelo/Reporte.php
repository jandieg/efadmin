<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Reporte
 *
 * @author Benito
 */
class Reporte extends Conexion{ 
    private $enero_fin;
    private $febrero_fin;
    private $marzo_fin;
    private $abril_fin;
    private $mayo_fin;
    private $junio_fin;
    private $julio_fin;
    private $agosto_fin;
    private $septiembre_fin;
    private $octubre_fin;
    private $noviembre_fin;
    private $diciembre_fin;
    
    private $enero_inicio;
    private $febrero_inicio;
    private $marzo_inicio;
    private $abril_inicio;
    private $mayo_inicio;
    private $junio_inicio;
    private $julio_inicio;
    private $agosto_inicio;
    private $septiembre_inicio;
    private $octubre_inicio;
    private $noviembre_inicio;
    private $diciembre_inicio;
    
    private $año;
    
    public function __construct(){
        parent:: __construct(); 

    }
    public function setEstablecerfehas($ano){
        
      /*  $this->enero_fin    = getUltimoDiaMes(date($ano),'1');
        $this->febrero_fin  = getUltimoDiaMes(date($ano),'2');
        $this->marzo_fin    = getUltimoDiaMes(date($ano),'3');
        $this->abril_fin    = getUltimoDiaMes(date($ano),'4');
        $this->mayo_fin     = getUltimoDiaMes(date($ano),'5');
        $this->junio_fin    = getUltimoDiaMes(date($ano),'6');
        $this->julio_fin       = getUltimoDiaMes(date($ano),'7');
        $this->agosto_fin      = getUltimoDiaMes(date($ano),'8');
        $this->septiembre_fin  = getUltimoDiaMes(date($ano),'9');
        $this->octubre_fin     = getUltimoDiaMes(date($ano),'10');
        $this->noviembre_fin   = getUltimoDiaMes(date($ano),'11');
        $this->diciembre_fin   = getUltimoDiaMes(date($ano),'12');*/
        
        $this->enero_fin    = getPrimerDiaMes(date($ano),'2');
        $this->febrero_fin  = getPrimerDiaMes(date($ano),'3');
        $this->marzo_fin    = getPrimerDiaMes(date($ano),'4');
        $this->abril_fin    = getPrimerDiaMes(date($ano),'5');
        $this->mayo_fin     = getPrimerDiaMes(date($ano),'6');
        $this->junio_fin    = getPrimerDiaMes(date($ano),'7');
        $this->julio_fin       = getPrimerDiaMes(date($ano),'8');
        $this->agosto_fin      = getPrimerDiaMes(date($ano),'9');
        $this->septiembre_fin  = getPrimerDiaMes(date($ano),'10');
        $this->octubre_fin     = getPrimerDiaMes(date($ano),'11');
        $this->noviembre_fin   = getPrimerDiaMes(date($ano),'12');
        $this->diciembre_fin   = getPrimerDiaMes(date($ano + 1),'1');
        
       $this->enero_inicio    = getPrimerDiaMes(date($ano),'1');
       $this->febrero_inicio  = getPrimerDiaMes(date($ano),'2');
       $this->marzo_inicio    = getPrimerDiaMes(date($ano),'3');
       $this->abril_inicio    = getPrimerDiaMes(date($ano),'4');
       $this->mayo_inicio     = getPrimerDiaMes(date($ano),'5');
       $this->junio_inicio    = getPrimerDiaMes(date($ano),'6');
       $this->julio_inicio       = getPrimerDiaMes(date($ano),'7');
       $this->agosto_inicio      = getPrimerDiaMes(date($ano),'8');
       $this->septiembre_inicio  = getPrimerDiaMes(date($ano),'9');
       $this->octubre_inicio     = getPrimerDiaMes(date($ano),'10');
       $this->noviembre_inicio   = getPrimerDiaMes(date($ano),'11');
       $this->diciembre_inicio   = getPrimerDiaMes(date($ano),'12');
       $this->año = $ano;
    }

     public function getPendientes($id_grupo) {
       
      $sql="call sp_selectReporteGruposCobrosPendientes("
                . "'$id_grupo',"
                . "'$this->enero_inicio',"
                . "'$this->febrero_inicio',"
                . "'$this->marzo_inicio',"
                . "'$this->abril_inicio',"
                . "'$this->mayo_inicio',"
                . "'$this->junio_inicio',"
                . "'$this->julio_inicio',"
                . "'$this->agosto_inicio',"
                . "'$this->septiembre_inicio',"
                . "'$this->octubre_inicio',"
                . "'$this->noviembre_inicio',"
                . "'$this->diciembre_inicio',"
                . "'$this->enero_fin',"
                . "'$this->febrero_fin',"
                . "'$this->marzo_fin',"
                . "'$this->abril_fin',"
                . "'$this->mayo_fin',"
                . "'$this->junio_fin',"
                . "'$this->julio_fin',"
                . "'$this->agosto_fin',"
                . "'$this->septiembre_fin',"
                . "'$this->octubre_fin',"
                . "'$this->noviembre_fin',"
                . "'$this->diciembre_fin',"
                . "'$this->año')";
        return parent::getConsultar($sql);   
    }
    public function get($id_grupo) {
       
      $sql="call sp_selectReporteGruposCobros("
                . "'$id_grupo',"
                . "'$this->enero_inicio',"
                . "'$this->febrero_inicio',"
                . "'$this->marzo_inicio',"
                . "'$this->abril_inicio',"
                . "'$this->mayo_inicio',"
                . "'$this->junio_inicio',"
                . "'$this->julio_inicio',"
                . "'$this->agosto_inicio',"
                . "'$this->septiembre_inicio',"
                . "'$this->octubre_inicio',"
                . "'$this->noviembre_inicio',"
                . "'$this->diciembre_inicio',"
                . "'$this->enero_fin',"
                . "'$this->febrero_fin',"
                . "'$this->marzo_fin',"
                . "'$this->abril_fin',"
                . "'$this->mayo_fin',"
                . "'$this->junio_fin',"
                . "'$this->julio_fin',"
                . "'$this->agosto_fin',"
                . "'$this->septiembre_fin',"
                . "'$this->octubre_fin',"
                . "'$this->noviembre_fin',"
                . "'$this->diciembre_fin')";
        return parent::getConsultar($sql);   
    }
    
//     public function get2($id_grupo) {
//       
//        $sql="
//            SELECT
//            miembro.mie_id,
//            miembro.mie_codigo as 'Código',
//            CONCAT(persona.per_apellido ,' ', persona.per_nombre) as 'nombre', 
//            miembro_inscripcion.mie_ins_fecha_ingreso as 'EF Paid', 
//            from_unixtime(miembro_inscripcion.mie_ins_fecha_cobro,'%Y-%m-%d') as '1st FM', 
//            miembro_inscripcion.mie_ins_valor as 'Dues Mo',
//            (SELECT sum( `cobro_total`) FROM `cobro` WHERE miembro_id=miembro.mie_id and (cobro_fecharegistro between '2016-01-01' and '2016-01-31')) as 'Enero',
//            (SELECT sum( `cobro_total`) FROM `cobro` WHERE miembro_id=miembro.mie_id and (cobro_fecharegistro between '2016-02-01' and '2016-02-31')) as 'Febrero',
//            (SELECT sum( `cobro_total`) FROM `cobro` WHERE miembro_id=miembro.mie_id and (cobro_fecharegistro between '2016-03-01' and '2016-03-31')) as 'Marzo',
//            (SELECT sum( `cobro_total`) FROM `cobro` WHERE miembro_id=miembro.mie_id and (cobro_fecharegistro between '2016-04-01' and '2016-04-31')) as 'Abril',
//            (SELECT sum( `cobro_total`) FROM `cobro` WHERE miembro_id=miembro.mie_id and (cobro_fecharegistro between '2016-05-01' and '2016-05-31')) as 'Mayo',
//            (SELECT sum( `cobro_total`) FROM `cobro` WHERE miembro_id=miembro.mie_id and (cobro_fecharegistro between '2016-06-01' and '2016-06-31')) as 'Junio',
//            (SELECT sum( `cobro_total`) FROM `cobro` WHERE miembro_id=miembro.mie_id and (cobro_fecharegistro between '2016-07-01' and '2016-07-31')) as 'Julio',
//            (SELECT sum( `cobro_total`) FROM `cobro` WHERE miembro_id=miembro.mie_id and (cobro_fecharegistro between '2016-08-01' and '2016-08-31')) as 'Agosto',
//            (SELECT sum( `cobro_total`) FROM `cobro` WHERE miembro_id=miembro.mie_id and (cobro_fecharegistro between '2016-09-01' and '2016-09-31')) as 'Septiembre',
//            (SELECT sum( `cobro_total`) FROM `cobro` WHERE miembro_id=miembro.mie_id and (cobro_fecharegistro between '2016-10-01' and '2016-10-31')) as 'Octubre',
//            (SELECT sum( `cobro_total`) FROM `cobro` WHERE miembro_id=miembro.mie_id and (cobro_fecharegistro between '2016-11-01' and '2016-11-31')) as 'Noviembre',
//            (SELECT sum( `cobro_total`) FROM `cobro` WHERE miembro_id=miembro.mie_id and (cobro_fecharegistro between '2016-12-01' and '2016-12-31')) as 'Diciembre',
//            (SELECT Sum(cobro_total) FROM detallecobro 
//            WHERE miembro_mie_id= miembro.mie_id and  (det_cobro_fecharegistro between '2016-01-01' and '2016-12-31')) as 'YTD'
//
//            FROM  miembro  
//            INNER join persona on miembro.Persona_per_id = persona.per_id 
//            Left join miembro_inscripcion on miembro.mie_id=miembro_inscripcion.miembro_id
//            where Binary miembro.grupo_id= '$id_grupo' 
//            ORDER BY nombre
//            ";
//        return parent::getConsultar($sql);   
//    }
}
