<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GeneradorPDF
 *
 * @author PRUEBAS
 */
require_once 'public/TCPDF-master/tcpdf.php';
class GeneradorPDF {
    
    private $orientacion;
    private $font;
    private $nombreArchivo;
    private $atributos = array('text-align' => 'center','font-weight' => 'bold', 'background-color' => '#FFFFFF');
    private $encabezado_titulo;
    private $encabezado_subtitulo;
    private $html;

    public function __construct($orientacion = 'L', $nombreArchivo = "default", $font = "helvetica")
    {
        $this->orientacion = $orientacion;
        $this->font =  $font;
        $this->nombreArchivo =  $nombreArchivo;
    }

    function getOrientacion() {
            return $this->orientacion;
    }

    function getFont() {
            return $this->font;
    }

    function getNombreArchivo() {
            return $this->nombreArchivo;
    }

    function getHtml() {
        return $this->html;
    }
    function setHtml($html="") {
        return $this->html = $html;
    }
    function getEncabezadoTitulo() {
        return $this->encabezado_titulo;
    }
    function setEncabezadoTitulo($encabezado_titulo="") {
        return $this->encabezado_titulo = $encabezado_titulo;
    }
    function getEncabezadoSubTitulo() {
        return $this->encabezado_subtitulo;
    }
    function setEncabezadoSubTitulo($encabezado_subtitulo="") {
        return $this->encabezado_subtitulo = $encabezado_subtitulo;
    }
    function getAtributos() {
            return $this->atributos;
    }

    function setAtributos($atributos) {
            $this->atributos = $atributos;
    }

    public function generadorTablaColumnas($columnas=array(), $color, $fontweight ){
        $t='';
        $t.='<tr style="background-color:'.$color.'; font-weight:'.$fontweight.';">'; 
        foreach ($columnas as $valor => $val) {
           $t.= '<th width="'.$val['width'].'"  >'.$val['valor'].'</th>';
        }     
        $t.='</tr>';

        return $t;
    }
       
    function generadorTablaFilas($filas= array()){
        $t='<tr>'; 
        foreach($filas as $valor){
            $t.= '<th>'.$valor.'</th>';
        }
        $t.= '</tr>';

        return $t;
    }
    public function generadorTabla( $columnas=array(), $filas){
        $t='';
        $t.='<table cellpadding="2" cellspacing="0" border="1" style="text-align:'.$this->atributos['text-align'].'; font-size:6px;" width="100%">';
        $t.='<tr style="background-color:'.$this->atributos['background-color'].'; font-weight:'.$this->atributos['font-weight'].';">'; 
        foreach ($columnas as $valor => $val) {
           $t.= '<th width="'.$val['width'].'"  >'.$val['valor'].'</th>';
        }     
        $t.='</tr>';
        $t.=$filas;
        $t.=' </table>';
        return $t;
    }
        
    function generadorGlosario($cuerpo= array()){
        $cont = '<table style="font-size:4px;" border="1" cellspacing="0" cellpadding="2" width="60%">';
        foreach ($cuerpo as $glo){
                $i = 0;
                $cont .= '<tr>';
                foreach ($glo as $g){
                        if($i == 0){
                                $cont .= '<td width="10%" bgcolor="" align="center">'.$g.'</td>';
                                $i = 1;
                        }else{
                                $cont .= '<td width="90%">'.$g.'</td>';
                        }

                }
                $cont .= '</tr>';
        }
        $cont .= '</table>';
        return $cont;
    }

        
    function setCrearV1() {
        
        $obj_pdf = new TCPDF($this->orientacion, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $obj_pdf->SetCreator(PDF_CREATOR);
        $obj_pdf->SetTitle($this->nombreArchivo);
        // set default header data
        $obj_pdf->SetHeaderData('', '', $this->encabezado_titulo, $this->encabezado_subtitulo, array(0,64,255), array(0,64,128));
        $obj_pdf->setFooterData(array(0,64,0), array(0,64,128));

        // set header and footer fonts
        $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set margins
        $obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $obj_pdf->AddPage();
        $tam = '60';
        if($this->orientacion == 'L'){
                $tam = $tam-20;
        }
        $obj_pdf->writeHTML($this->html);  
        $obj_pdf->Output($this->nombreArchivo.'.pdf', 'I');
    }
    function setCrearV2() {//Con encabezado y pie de pagina
        require_once 'public/TCPDF-master/tcpdf.php';
        $obj_pdf = new TCPDF($this->orientacion, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $obj_pdf->SetCreator(PDF_CREATOR);
        $obj_pdf->SetTitle($this->nombreArchivo);
        $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $obj_pdf->SetDefaultMonospacedFont($this->font);
        $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
        $obj_pdf->setPrintHeader(false);
        $obj_pdf->setPrintFooter(false);
        $obj_pdf->SetAutoPageBreak(TRUE, 10);
        $obj_pdf->SetFont($this->font, '', 12);
        $obj_pdf->AddPage();
        $tam = '60';
        if($this->orientacion == 'L'){
                $tam = $tam-20;
        }
        $obj_pdf->writeHTML($this->html);  
        $obj_pdf->Output($this->nombreArchivo.'.pdf', 'I');
    }
 
        
    public function __destruct(){
        unset($this->orientacion);
    }
}