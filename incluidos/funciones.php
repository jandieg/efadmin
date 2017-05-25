<?php
function listaDir($carpeta,$decide="excluye",$extensiones=array("htm","html")){
	// esta funcion devuelve un array con los nombres de archivos existentes en una carpeta
	// se excluyen los tipos "." ".." así como los archivos que inicien con "_"
	// La variable $decide sirve para decidir si el arreglo resultante de esta función 
    // debe incluir o no las extensiones del parámetro "$extensiones"
	$resultado = array();
	if ($gestor = opendir($carpeta)){
		while (FALSE !== ($miembro = readdir($gestor))) {
			if ($miembro != "." && $miembro != ".." && substr($miembro,0,1) != "_") {
				$om = substr(strrchr(strtolower($miembro),"."),1); // esto me entrega la extensión del archivo evaluado en la iteración
				// averiguo si el procedimiento es para "incluir" o para "omitir" las extensiones dadas
				switch($decide){
					case "excluye":
						// se excluirán los archivos de las extensiones presentes en "$extensiones"
						if(!in_array($om,$extensiones)){ // si las extensión $om [NO ESTÁ] en el arreglo de estensiones
							array_push($resultado,$miembro);	
						}
					break;
					case "incluye":
						// Sólo se incluirán los archivos con extensiones en "$extensiones"
						if(in_array($om,$extensiones)){ // si las extensión $om [ESTÁ] en el arreglo de estensiones
							array_push($resultado,$miembro);	
						}
					break;
					case "dir":
						if(is_dir($carpeta."/".$miembro)){ // si el elemento a evaluar es una carpeta
							array_push($resultado,$miembro);	
						}
					break;
					case "file":
						if(is_file($carpeta."/".$miembro)){ // si el elemento a evaluar es un archivo
							array_push($resultado,$miembro);	
						}
					break;
					default:
					// se incluirán todos los archivos
					array_push($resultado,$miembro);	
				}
			}
		}
	}
	closedir($gestor);
return $resultado;
}

function ett($a,$b){
	$retorno = "<".$b.">".$a."</".$b.">";
	return $retorno;
        
}
function getPage($page){
    if(file_exists(E_VISTAS.E_PAGE."/page/".$page.".php")){
        $msg= file_get_contents(E_VISTAS.E_PAGE."/page/".$page.".php");
    }  else {                     
        $msg='<div class="alert alert-danger alert-dismissible" role="alert">';
        $msg.='<button type="button"  class="close" data-dismiss="alert" aria-label="Close" onclick="getRecargar()"><span aria-hidden="true">&times;</span></button>';
        $msg.='<strong>Alerta! </strong>Esta pagina no existe!</div>';  
    }
    return $msg;
}
function getAlertNoPage(){
                      
    $msg='<div class="alert alert-danger alert-dismissible" role="alert">';
    $msg.='<button type="button"  class="close" data-dismiss="alert" aria-label="Close" onclick="getRecargar()"><span aria-hidden="true">&times;</span></button>';
    $msg.='<strong>Alerta! </strong>Esta pagina no existe!</div>';  
    
    return $msg;
}


function redirect($location){
    header('Location: '.$location);
}

function getUltimoDiaMes($elAnio,$elMes) {
  return date("Y-m-d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
}
function getGenerarFechas($elAnio,$periodo, $fechaPartida) {
	$listaFechaV="";				
	for ($index = $periodo; $index <= 12; $index = $index + $periodo) {
		$fecha= getUltimoDiaMes($elAnio,$index);
		if($fecha >= $fechaPartida){
			$listaFechaV.= $fecha.",";
		}
		
	}
	return $listaFechaV;
}

function getPrimerDiaMes($elAnio,$elMes) {
  return date('Y-m-d', mktime(0,0,0, $elMes, 1, $elAnio));
}
function getFormatoFechadmyhis($fecha) {
    if($fecha == '0000-00-00' || $fecha == '0000-00-00 00:00:00' || $fecha == ''){
        return '';
    }else{
        return date('d/m/Y H:i:s',strtotime($fecha));
    }
  
}
function getFormatoFechadmy($fecha) {
    if($fecha == '0000-00-00' ||  $fecha == ''){
        return '';
    }else{
        return date('d/m/Y',strtotime($fecha));
    }
  
}


function getMesTexto($tipo) {
    switch ($tipo) {
        case 1:
            return 'Jan';
            break;
        case 2:
            return 'Feb';
            break;
        case 3:
            return 'Mar';
            break;
        case 4:
            return 'Apr';
            break;
        case 5:
            return 'May';
            break;
        case 6:
            return 'Jun';
            break;
        case 7:
            return 'Jul';
            break;
        case 8:
            return 'Aug';
            break;
        case 9:
            return 'Sep';
            break;
        case 10:
            return 'Oct';
            break;
        case 11:
            return 'Nov';
            break;
        case 12:
            return 'Dec';
            break;
       
    }
    
}

//This will return true if the password is correct, false otherwise.
function testPassword($fPassword, $fSaltFromDatabase, $fHashFromDatabase){//hash_hmac("sha256", trim($_POST['_contraseña']), $salt);
  if (hash_hmac("sha256", trim($fPassword), $fSaltFromDatabase) === $fHashFromDatabase){
    return(true);
  }else{
    return(false);
  }
}
function generateSalt() {
    $length = 64; 
    $intermediateSalt = md5(uniqid(rand(), true));
    $salt = substr($intermediateSalt, 0, $length);
    return  $salt.  generateComplementoSalt();
}
//This will generate a 256 bit hex value
function generateComplementoSalt(){
  //$characters = '0123456789abcdefghijkmnopqrstuvwxyz';
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890|@#~$%()=^*+[]{}-_';
  $length = 64; $string = '';
  for ($max = mb_strlen($characters) - 1, $i = 0; $i < $length; ++ $i) {
    $string .= mb_substr($characters, mt_rand(0, $max), 1);
  }
  return $string;
}

function generaPass($lon){
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890|@#~$%()=^*+[]{}-_";
    $longitudCadena=strlen($cadena);
    $pass = "";
    $longitudPass= $lon;
    for($i=1 ; $i<=$longitudPass ; $i++){
        $pos= rand(0,$longitudCadena-1);
        $pass .= substr($cadena,$pos,1);
    }
    return $pass;
}
