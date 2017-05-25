<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GenerarFechas
 *
 * @author Benito
 */
class GenerarFechas {
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


    }
    public function setEstablecerfehas($ano){
        
        $this->enero_fin    = getUltimoDiaMes(date($ano),'1');
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
        $this->diciembre_fin   = getUltimoDiaMes(date($ano),'12');
        
        
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
    
    function getEneroFin() {
        return $this->enero_fin;
    }
    function getFebreroFin() {
        return $this->febrero_fin;
    }
    function getMarzoFin() {
        return $this->marzo_fin;
    }
    function getAbrilFin() {
        return $this->abril_fin;
    }
    function getMayoFin() {
        return $this->mayo_fin;
    }
    function getJunioFin() {
        return $this->junio_fin;
    }
    function getJulioFin() {
        return $this->julio_fin;
    }
    function getAgostoFin() {
        return $this->agosto_fin;
    }
    function getSeptiembreFin() {
        return $this->septiembre_fin;
    }
    function getOctubreFin() {
        return $this->octubre_fin;
    }
    function getNoviembreFin() {
        return $this->noviembre_fin;
    }
    function getDiciembreFin() {
        return $this->diciembre_fin;
    }
    ////////////////////////////////////////////////////////////////////////////
    
    function getEneroInicio() {
        return $this->enero_inicio;
    }
    function getFebreroInicio() {
        return $this->febrero_inicio;
    }
    function getMarzoInicio() {
        return $this->marzo_inicio;
    }
    function getAbrilInicio() {
        return $this->abril_inicio;
    }
    function getMayoInicio() {
        return $this->mayo_inicio;
    }
    function getJunioInicio() {
        return $this->junio_inicio;
    }
    function getJulioInicio() {
        return $this->julio_inicio;
    }
    function getAgostoInicio() {
        return $this->agosto_inicio;
    }
    function getSeptiembreInicio() {
        return $this->septiembre_inicio;
    }
    function getOctubreInicio() {
        return $this->octubre_inicio;
    }
    function getNoviembreInicio() {
        return $this->noviembre_inicio;
    }
    function getDiciembreInicio() {
        return $this->diciembre_inicio;
    }
   

}