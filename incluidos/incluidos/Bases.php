<?php
//considerar 2017dbef
function setDatosConexion($key){
    switch ($key) {
        case 'dbexecutiveforumsperu':    
            $_SESSION['host'] = 'localhost';
            $_SESSION['user'] =  'execforum';
            $_SESSION['pass'] =  'Ex3cF0rumS2017%8';
            $_SESSION['db'] =  'execforums';
            break;
        case 'bases':          
            $_SESSION['databases'] = 'execforums,';
            break;
        default:
            $_SESSION['host'] = 'localhost';
            $_SESSION['user'] =  'execforum';
            $_SESSION['pass'] =  'Ex3cF0rumS2017%8';
            $_SESSION['db'] =  'execforums';
            
            break;
    }
    
}