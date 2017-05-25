<?php
if(!isset($_SESSION)){
    session_set_cookie_params(0);
    session_start();  
}

define ("E_RAIZ","../");
define("E_LIB",E_RAIZ."incluidos/");
define("E_VISTAS",E_RAIZ."vistas/");
define("MODELO",E_LIB."modelo/");
define("MODELO2",E_LIB."modelo2/");
//define("HTML",E_LIB."html/");
//define("LENGUAJE",E_LIB."lenguaje/");
define("PERMISOS",E_LIB."permisos/");

require_once E_LIB.'Conexion.php';
require_once E_LIB.'msg.php';
require_once E_LIB.'funciones.php';
require_once E_LIB.'Bases.php';
include(PERMISOS."/permisos.php");
//include(LENGUAJE."/lenguaje_2.php");
date_default_timezone_set ("America/Guayaquil");

$_SITE_PAGES = listaDir(E_VISTAS,"dir"); //genera arreglo con los directorios que aparecen en la carpeta (sub en el sitio público)
                  
if(isset($_REQUEST['url'])){
	if(in_array($_REQUEST['url'],$_SITE_PAGES)){
                define("E_PAGE", $_REQUEST['url']);
                if(file_exists(E_VISTAS.E_PAGE."/head.php")){
                    include(E_VISTAS.E_PAGE."/head.php");
                }
	}
}else {
    define("E_PAGE", "inicio");
    if(file_exists(E_VISTAS.E_PAGE."/head.php")){
        include(E_VISTAS.E_PAGE."/head.php");
    }	
}
?>
