<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pago
 *
 * @author Benito
 */
class Pago extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    public function getPagoValorForumGrupos( $fi, $ff, $forum) {
        $fecha_tope= $ff." 23:59:00";
        $sql="call sp_selectPagoForumGrupos('$fi','$ff','$forum','$fecha_tope')";
        return parent::getConsultar($sql);   
    }
    public function getPagos() {
        $sql="call sp_selectPagos()";
        return parent::getConsultar($sql);   
    }
    public function setPagoValorForumGrupos($id_tipo_pago,  $valor, $porcentaje,$id_forum,$fecha_inicio, $fecha_fin,    $id_usuario,$nota,$porcentaje_pagar) {
        $fecha= date("Y-m-d H:i:s");
        $fecha_tope= $fecha_fin." 23:59:00";
        $sql="call sp_createPagoForumGrupos('$id_tipo_pago','$valor','$porcentaje','$id_forum',"
                . " '$fecha_inicio', '$fecha_fin', '$fecha', '$id_usuario', '$nota','$fecha_tope','$porcentaje_pagar')";
        return parent::setSqlSp($sql);   
    }
public function getPagoValorFranquicia($id_tipo_pago, $fi, $ff,$fecha_topoe_pago) {

        $sql="call sp_selectPagoFranquicia('$id_tipo_pago','$fi','$ff','$fecha_topoe_pago')";
        return parent::getConsultar($sql);   
    }
    public function setPagoValorFranquicia($id_tipo_pago,$fecha_inicio, $fecha_fin,  $valor, $porcentaje,  $id_usuario,$valor_base, $nota,$porcentaje_pagar) {
        $fecha= date("Y-m-d H:i:s");
        $fecha_tope= $fecha_fin." 23:59:00";
        $sql="call sp_createPagoFranquicia('$id_tipo_pago','$fecha_inicio', '$fecha_fin', '$fecha', '$valor', "
                . "'$porcentaje',  '$id_usuario','$valor_base', '$nota','$fecha_tope', '$porcentaje_pagar')";
        return parent::setSqlSp($sql);   
    }
    public function setPagoValorForumMiembros($id_tipo_pago,$lista, $valor, $forum,  $id_usuario, $nota) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createPagoForumMiembros('$id_tipo_pago','$lista',  '$valor', "
                . "'$forum', '$fecha', '$id_usuario','$nota')";
        return parent::setSqlSp($sql);   
    }
    public function setPagoValorForumOtros($id_tipo_pago,$valor, $forum,  $id_usuario, $nota) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createPagoForumOtros('$id_tipo_pago',  '$valor', "
                . "'$forum', '$fecha', '$id_usuario','$nota')";
        return parent::setSqlSp($sql);   
    }
      public function setPagoValorVarios($id_tipo_pago,$valor, $id_usuario, $nota) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createPagoVarios('$id_tipo_pago',  '$valor', "
                . " '$fecha', '$id_usuario','$nota')";
        return parent::setSqlSp($sql);   
    }

}
//CREATE  PROCEDURE sp_createPagoForumOtros(
//IN _id_tipo_pago INT, 
//IN _valor DOUBLE, 
//IN _id_forum INT, 
//IN _fecharegistro TIMESTAMP, 
//IN _id_usuario INT,
//IN _nota Varchar(250))  BEGIN
