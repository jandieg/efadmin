<?php 
require_once MODELO.'Entity.php';
require_once MODELO.'GenerarFechas.php';
require_once MODELO.'EntityGrupo.php';

$data = json_decode(file_get_contents("php://input")); 
if (isset($data)) {
    try{
        switch ($data->KEY):
		
            case 'KEY_REPORTE_COBRO':
                validarHash($data->_hash, $data->_id . $data->_user . $data->_id);
                setDatosConexion($data->_base);
                setDatosConexion('bases'); 

                $year = $data->_year;    
                if($year == ''){
                    $year = date('Y');
                }
		
		$objGenerarFecha= new GenerarFechas();
                $objGenerarFecha->setEstablecerfehas( $year);
		
		
                $resultset= array();
                $response_1= array();
                $objCobro= new Entity($response_1);
                $parametros= array(
                    $data->_grupo, 
                    $objGenerarFecha->getEneroInicio(),
                    $objGenerarFecha->getFebreroInicio(),
                    $objGenerarFecha->getMarzoInicio(),
                    $objGenerarFecha->getAbrilInicio(),
                    $objGenerarFecha->getMayoInicio(),
                    $objGenerarFecha->getJunioInicio(),
                    $objGenerarFecha->getJulioInicio(),
                    $objGenerarFecha->getAgostoInicio(),
                    $objGenerarFecha->getSeptiembreInicio(),
                    $objGenerarFecha->getOctubreInicio(),
                    $objGenerarFecha->getNoviembreInicio(),
                    $objGenerarFecha->getDiciembreInicio(),
                    $objGenerarFecha->getEneroFin(),
                    $objGenerarFecha->getFebreroFin(),
                    $objGenerarFecha->getMarzoFin(),
                    $objGenerarFecha->getAbrilFin(),
                    $objGenerarFecha->getMayoFin(),
                    $objGenerarFecha->getJunioFin(),
                    $objGenerarFecha->getJulioFin(),
                    $objGenerarFecha->getAgostoFin(),
                    $objGenerarFecha->getSeptiembreFin(),
                    $objGenerarFecha->getOctubreFin(),
                    $objGenerarFecha->getNoviembreFin(),
                    $objGenerarFecha->getDiciembreFin()
                    );
                
                 if($data->_tipo_reporte == '2'){
                     $resultset= $objCobro->getSp('sp_selectReporteGruposCobros', $parametros, 'reporte_cobros');
                }else{
					array_push($parametros, $year);
                    $resultset= $objCobro->getSp('sp_selectReporteGruposCobrosPendientes', $parametros, 'reporte_cobros');
                }
                
           
                $duesmo= array();
                $enero= array();
                $febrero = array();
                $marzo= array();
                $abril= array();
                $mayo = array();
                $junio= array();
                $julio= array();
                $agosto = array();
                $septiembre= array();
                $octubre= array();
                $noviembre = array();
                $diciembre= array();
                $ytd= array();   
				$color='op1';
                 foreach ($resultset['reporte_cobros'] as $rows => $row){
                    if( $color == 'op1'){
                            $color='op2';
                    }else{
                            $color='op1';
                    }
                    $codigo= (($row['Código'] == "zzz") ? "Total" : $row['Código']) ;
                    //$nombre= $row['nombre'];
					setlocale(LC_MONETARY, 'en_US');
                    $duesmo []=   array(    "codigo" => $codigo,
                                            "nombre" => $row['nombre'],
                                            "EF Paid" => (($row['EF Paid'] == "") ? "" : date('m-Y',strtotime($row['EF Paid']))),
                                            "1st FM" => (($row['1st FM'] == "") ? "" : date('m-Y',strtotime($row['1st FM']))),
                                            "valor" => money_format('%(#2n',  $row['Dues Mo']),
					"color" =>  $color); 
                            
                    $enero[]=   array(  "codigo" => $codigo,
                                        "nombre" => $row['nombre'],
                                        "valor" =>  money_format('%(#2n',$row['Enero']),
									   		"color" =>  $color); 
                    $febrero[]= array(  "codigo" => $codigo,
                                        "nombre" => $row['nombre'],
                                        "valor" =>   money_format('%(#2n',  $row['Febrero']) ,
									   		"color" =>  $color); 
                    $marzo[]=   array(  "codigo" => $codigo,
                                        "nombre" => $row['nombre'],
                                        "valor" =>    money_format('%(#2n', $row['Marzo']),
									   		"color" =>  $color); 
                    $abril[]= array(   "codigo" => $codigo,
                                        "nombre" => $row['nombre'],
                                        "valor" =>  money_format('%(#2n', $row['Abril']),
									   		"color" =>  $color); 
                    $mayo[]=   array(  "codigo" => $codigo,
                                        "nombre" => $row['nombre'],
                                        "valor" =>   money_format('%(#2n',$row['Mayo']),
									   		"color" =>  $color); 
                    $junio[]= array(  "codigo" => $codigo,
                                        "nombre" => $row['nombre'],
                                        "valor" =>   money_format('%(#2n',$row['Junio']),
									   		"color" =>  $color); 
                    $julio[]=   array(  "codigo" => $codigo,
                                        "nombre" => $row['nombre'],
                                        "valor" =>  money_format('%(#2n', $row['Julio']),
									   		"color" =>  $color); 
                    $agosto[]= array(  "codigo" => $codigo,
                                        "nombre" => $row['nombre'],
                                        "valor" =>   money_format('%(#2n',$row['Agosto']),
									   		"color" =>  $color); 
                    $septiembre[]=array("codigo" => $codigo,
                                        "nombre" => $row['nombre'],
                                        "valor" =>   money_format('%(#2n',$row['Septiembre']),
									   		"color" =>  $color); 
                    $octubre[]= array(  "codigo" => $codigo,
                                        "nombre" => $row['nombre'],
                                        "valor" =>   money_format('%(#2n',$row['Octubre']),
									   		"color" =>  $color); 
                    $noviembre[]=array(  "codigo" => $codigo,
                                        "nombre" => $row['nombre'],
                                        "valor" =>   money_format('%(#2n',$row['Noviembre']),
									   		"color" =>  $color); 
                    $diciembre[]= array("codigo" => $codigo,
                                        "nombre" => $row['nombre'],
                                        "valor" =>   money_format('%(#2n',$row['Diciembre']),
									   		"color" =>  $color); 
                    
                    $ytd[]= array(      "codigo" => $codigo,
                                        "nombre" => $row['nombre'],
                                        "valor" =>   money_format('%(#2n',$row['YTD']),
									   		"color" =>  $color);
                  
                }
               $lista_valores= array();
                //$lista_valores[]= array("titulo" => "Inscripción", "valores" => $duesmo) ;
                $lista_valores[]=  array("titulo" => "Enero", "valores" =>$enero);
                $lista_valores[]=  array("titulo" => "Febrero", "valores" =>$febrero);
                $lista_valores[]=  array("titulo" => "Marzo", "valores" =>$marzo);
                $lista_valores[]=  array("titulo" => "Abril", "valores" =>$abril);
                $lista_valores[]=  array("titulo" => "Mayo", "valores" =>$mayo);
                $lista_valores[]=  array("titulo" => "Junio", "valores" =>$junio);
                $lista_valores[]=  array("titulo" => "Julio", "valores" =>$julio);
                $lista_valores[]=  array("titulo" => "Agosto", "valores" =>$agosto);
                $lista_valores[]= array("titulo" => "Septiembre", "valores" => $septiembre);
                $lista_valores[]=  array("titulo" => "Octubre", "valores" =>$octubre);
                $lista_valores[]=  array("titulo" => "Noviembre", "valores" =>$noviembre);
                $lista_valores[]= array("titulo" => "Diciembre", "valores" => $diciembre);
                $lista_valores[]=  array("titulo" => "YTD", "valores" =>$ytd);
                $res["valores"] = $lista_valores; 
      

                 if(count($resultset['reporte_cobros']) > 0 ){
                    $res["success"] = "1"; 
                    echo json_encode($res); 
                }else{
                    $res["success"] = "2"; 
                    $res["msg"] = "No existe Información!"; 
                    echo json_encode($res); 
                }
                
            exit();
            break;
		
		 case 'KEY_FILTROS_GRUPO':
                validarHash($data->_hash, $data->_id . $data->_user . $data->_id);
                setDatosConexion($data->_base);
                setDatosConexion('bases'); 
  		
                $resultset= array();
                $response_1= array();
                $objGrupo= new EntityGrupo($response_1);
                $resultset= $objGrupo->getFiltro('grupos', $data->_id, $data->_permiso, $perVerTodosFiltrosReportesCobroOp15, $perVerFiltrosIDForumReportesCobroOp15);
                
                if(count($resultset['grupos']) > 0 ){
                    $resultset["success"] = "1"; 
                    echo json_encode($resultset); 
                }else{
                    $resultset["success"] = "2"; 
                    $resultset["msg"] = "No existe Información!"; 
                    echo json_encode($resultset); 
                }
                 exit();
                
                break; 
   
        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}  
} else { 
    echo getNull();
}  
exit();