<?php
require_once MODELO.'Sede.php';

public $monedas = array(
'AED' => 'Emiratos Arabes Unidos',
'AFN' => 'Afghani Afghanistan',
'ALL' => 'Lek Albano',
'AMD' => 'Dram Armeno',
'ANG' => 'Guilder (Antillas Holandesas)',
'AOA' => 'Kwanza Angolano',
'ARS' => 'Peso Argentino',
'AUD' => 'Dolar Australiano',
'AWG' => 'Guilder (Aruba)',
'AZN' => 'Manat (Azerbaijan)',
'BAM' => 'Marka Convertible (Bonsia y Herzegovina)',
'BBD' => 'Dolar de Barbados',
'BDT' => 'Taka de Bangladesh',
'BGN' => 'Lev Bulgaro',
'BHD' => 'Dinar (Bahrein)',
'BIF' => 'Franco de Burundi',
'BMD' => 'Dolar de Bermuda',
'BND' => 'Dolar de Brunei',
'BOB' => 'Boliviano (Bolivia)',
'BRL' => 'Real Brasilero',
'BSD' => 'Dolar de las Bahamas',
'BTN' => 'Ngultrum Butanes',
'BWP' => 'Pula (Botsuana)',	 
'BYN' => 'Rublo (Belarus)',
'BZD' => 'Dolar de Belize',
'CAD' => 'Dolar Canadiense',
'CDF' => 'Franco del Congo',	
'CHF' => 'Franco suizo',
'CLP' => 'Peso Chileno',
'CNY' => 'Yuan Chino',
'COP' => 'Peso Colombiano',
'CRC' => 'Colon Costarricense',
'CUC' => 'Peso Cubano Convertible',
'CUP' => 'Peso Cubano',
'CVE' => 'Escudo Cape Verde',
'CZK' => 'Republica Checa',
'DJF' => 'Franco de Djibouti',
'DKK' => 'Corona Danesa',
'DOP' => 'Peso Dominicano',
'DZD' => 'Dinar Argelino',	
'EGP' => 'Libra Egipcia',
ERN	Eritrea Nakfa
ETB	Ethiopia Birr
EUR	Euro Member Countries
FJD	Fiji Dollar
FKP	Falkland Islands (Malvinas) Pound
GBP	United Kingdom Pound
GEL	Georgia Lari
GGP	Guernsey Pound
GHS	Ghana Cedi
GIP	Gibraltar Pound
GMD	Gambia Dalasi
GNF	Guinea Franc
GTQ	Guatemala Quetzal
GYD	Guyana Dollar
HKD	Hong Kong Dollar
HNL	Honduras Lempira
HRK	Croatia Kuna
HTG	Haiti Gourde
HUF	Hungary Forint
IDR	Indonesia Rupiah
ILS	Israel Shekel
IMP	Isle of Man Pound
INR	India Rupee
IQD	Iraq Dinar
IRR	Iran Rial
ISK	Iceland Krona
JEP	Jersey Pound
JMD	Jamaica Dollar
JOD	Jordan Dinar
JPY	Japan Yen
KES	Kenya Shilling
KGS	Kyrgyzstan Som
KHR	Cambodia Riel
KMF	Comorian Franc
KPW	Korea (North) Won
KRW	Korea (South) Won
KWD	Kuwait Dinar
KYD	Cayman Islands Dollar
KZT	Kazakhstan Tenge
LAK	Laos Kip
LBP	Lebanon Pound
LKR	Sri Lanka Rupee
LRD	Liberia Dollar
LSL	Lesotho Loti
LYD	Libya Dinar
MAD	Morocco Dirham
MDL	Moldova Leu
MGA	Madagascar Ariary
MKD	Macedonia Denar
MMK	Myanmar (Burma) Kyat
MNT	Mongolia Tughrik
MOP	Macau Pataca
MRO	Mauritania Ouguiya
MUR	Mauritius Rupee
MVR	Maldives (Maldive Islands) Rufiyaa
MWK	Malawi Kwacha
MXN	Mexico Peso
MYR	Malaysia Ringgit
MZN	Mozambique Metical
NAD	Namibia Dollar
NGN	Nigeria Naira
NIO	Nicaragua Cordoba
NOK	Norway Krone
NPR	Nepal Rupee
NZD	New Zealand Dollar
OMR	Oman Rial
PAB	Panama Balboa
PEN	Peru Sol
PGK	Papua New Guinea Kina
PHP	Philippines Peso
PKR	Pakistan Rupee
PLN	Poland Zloty
PYG	Paraguay Guarani
QAR	Qatar Riyal
RON	Romania Leu
RSD	Serbia Dinar
RUB	Russia Ruble
RWF	Rwanda Franc
SAR	Saudi Arabia Riyal
SBD	Solomon Islands Dollar
SCR	Seychelles Rupee
SDG	Sudan Pound
SEK	Sweden Krona
SGD	Singapore Dollar
SHP	Saint Helena Pound
SLL	Sierra Leone Leone
SOS	Somalia Shilling
SPL*	Seborga Luigino
SRD	Suriname Dollar
STD	São Tomé and Príncipe Dobra
SVC	El Salvador Colon
SYP	Syria Pound
SZL	Swaziland Lilangeni
THB	Thailand Baht
TJS	Tajikistan Somoni
TMT	Turkmenistan Manat
TND	Tunisia Dinar
TOP	Tonga Pa'anga
TRY	Turkey Lira
TTD	Trinidad and Tobago Dollar
TVD	Tuvalu Dollar
TWD	Taiwan New Dollar
TZS	Tanzania Shilling
UAH	Ukraine Hryvnia
UGX	Uganda Shilling
USD	United States Dollar
UYU	Uruguay Peso
UZS	Uzbekistan Som
VEF	Venezuela Bolívar
VND	Viet Nam Dong
VUV	Vanuatu Vatu
WST	Samoa Tala
XAF	Communauté Financière Africaine (BEAC) CFA Franc BEAC
XCD	East Caribbean Dollar
XDR	International Monetary Fund (IMF) Special Drawing Rights
XOF	Communauté Financière Africaine (BCEAO) Franc
XPF	Comptoirs Français du Pacifique (CFP) Franc
YER	Yemen Rial
ZAR	South Africa Rand
ZMW	Zambia Kwacha
ZWD	Zimbabwe Dollar

);

function getTipoCambio($anho) {
    $objSede = new Sede();
    $resultset = $objSede->getTipoCambio($anho,$_SESSION['user_id_ben']);
    $data = array();
    $i = 0;
    while ($row = $resultset->fetch_assoc()) {
        $data[$i]['sede'] = $row['sede_razonsocial'];
        $data[$i]['sede_id'] = $row['sede_id'];
        $data[$i]['mes'] = $row['mes'];
        $data[$i]['cambio'] = $row['cambio'];
        $data[$i]['moneda'] = $row['moneda'];
        $i++;
    }
    return $data;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']):
        case 'KEY_GUARDAR_CAMBIO' :
         $objSede1 = new Sede();
         $objSede2 = new Sede();
         $objSede3 = new Sede();
         $objSede4 = new Sede();
         $objSede5 = new Sede();
         $objSede6 = new Sede();
         $objSede7 = new Sede();
         $objSede8 = new Sede();
         $objSede9 = new Sede();
         $objSede10 = new Sede();
         $objSede11 = new Sede();
         $objSede12 = new Sede();
         $anho = $_POST['_anho'];
         $sede = $_POST['_sede'];
         print_r($objSede1->setTipoCambio(1, $anho, $sede, $_POST['_mes_1'], $_POST['_moneda']));
         $comp = $objSede2->setTipoCambio(2, $anho, $sede, $_POST['_mes_2'], $_POST['_moneda']);
         $comp = $objSede3->setTipoCambio(3, $anho, $sede, $_POST['_mes_3'], $_POST['_moneda']);
         $comp = $objSede4->setTipoCambio(4, $anho, $sede, $_POST['_mes_4'], $_POST['_moneda']);
         $comp = $objSede5->setTipoCambio(5, $anho, $sede, $_POST['_mes_5'], $_POST['_moneda']);
         $comp = $objSede6->setTipoCambio(6, $anho, $sede, $_POST['_mes_6'], $_POST['_moneda']);
         $comp = $objSede7->setTipoCambio(7, $anho, $sede, $_POST['_mes_7'], $_POST['_moneda']);
         $comp = $objSede8->setTipoCambio(8, $anho, $sede, $_POST['_mes_8'], $_POST['_moneda']);
         $comp = $objSede9->setTipoCambio(9, $anho, $sede, $_POST['_mes_9'], $_POST['_moneda']);
         $comp = $objSede10->setTipoCambio(10, $anho, $sede, $_POST['_mes_10'], $_POST['_moneda']);
         $comp = $objSede11->setTipoCambio(11, $anho, $sede, $_POST['_mes_11'], $_POST['_moneda']);
         $comp = $objSede12->setTipoCambio(12, $anho, $sede, $_POST['_mes_12'], $_POST['_moneda']);
         echo $comp;
        break;
         case 'KEY_GET_CAMBIO':
         $meses = array(
             1=>'Enero',
             2=>'Febrero',
             3=>'Marzo',
             4=>'Abril',
             5=>'Mayo',
             6=>'Junio',
             7=>'Julio',
             8=>'Agosto',
             9=>'Septiembre',
             10=>'Octubre',
             11=>'Noviembre',
             12=>'Diciembre'             
         );
         $datosm = array(
             1=>1,
             2=>1,
             3=>1,
             4=>1,
             5=>1,
             6=>1,
             7=>1,
             8=>1,
             9=>1,
             10=>1,
             11=>1,
             12=>1
         );
         $anho = date('Y');
         $datos = getTipoCambio($anho);
         $lasede = "";
         $lamoneda = "";
         $lasedeid = "";
         foreach ($datos as $d) {
            $lasede = $d['sede'];
            $lasedeid = $d['sede_id'];
            $lamoneda = $d['moneda'];
            if (strlen($d['mes']) > 0) {
                $datosm[intval($d['mes'])] = $d['cambio'];
            }
         }

         $lista = "<div class='flex-container'>"
         ."<div>".$datos['sede'] ."</div><input type='hidden' id='_la_sede' value ='".$lasedeid."'><div>"
         ."</div>";
         $deshabilitado = '';
         if (! in_array(trim($_SESSION['user_perfil']), array('Administrador Regional'))) {
             $deshabilitado = 'disabled';
         }
         
         $lista .= "<div class='row'>
         <div class='span2 lista-botones'><span><strong>Sede: ".$lasede."</strong></span></div>
         <div class='span2 lista-botones'><span><strong>Moneda: </strong></span><input type='text' id='_la_moneda' value='".$lamoneda."' "
         .$deshabilitado."></div>";
         foreach($datosm as $k => $dd) {
             $lista.= "<div class='span2 lista-botones'><span><strong>".$meses[$k].": </strong></span><input ".$deshabilitado." type='text' id='mes_".$k."' value='".$dd."' /></div>";
         }
         $lista .="</div>";
         $lista .="</div>";
         echo $lista;
         break;

          case 'KEY_GET_CAMBIO2':
         $meses = array(
             1=>'Enero',
             2=>'Febrero',
             3=>'Marzo',
             4=>'Abril',
             5=>'Mayo',
             6=>'Junio',
             7=>'Julio',
             8=>'Agosto',
             9=>'Septiembre',
             10=>'Octubre',
             11=>'Noviembre',
             12=>'Diciembre'             
         );
         $datosm = array(
             1=>1,
             2=>1,
             3=>1,
             4=>1,
             5=>1,
             6=>1,
             7=>1,
             8=>1,
             9=>1,
             10=>1,
             11=>1,
             12=>1
         );
         $anho = $_POST['_anho'];
         $datos = getTipoCambio($anho);
         $lasede = "";
         $lamoneda = "";
         $lasedeid = "";
         foreach ($datos as $d) {
            $lasede = $d['sede'];
            $lasedeid = $d['sede_id'];
            $lamoneda = $d['moneda'];
            if (strlen($d['mes']) > 0) {
                $datosm[intval($d['mes'])] = $d['cambio'];
            }
         }

         $lista = "<div class='flex-container'>"
         ."<div><strong>".$datos['sede'] ."</strong></div><input type='hidden' id='_la_sede' value ='".$lasedeid."'><div>"
         ."</div>";
         $deshabilitado = '';
         if (! in_array(trim($_SESSION['user_perfil']), array('Administrador Regional'))) {
             $deshabilitado = 'disabled';
         }
         $lista .= "<div class='row'>
         <div class='span2 lista-botones'><span><strong>Sede: ".$lasede."</strong></span></div>
         <div class='span2 lista-botones'><span><strong>Moneda: </strong></span><input type='text' id='_la_moneda' value='".$lamoneda."' "
         .$deshabilitado."></div>";
         foreach($datosm as $k => $dd) {
             $lista.= "<div class='span2 lista-botones'><span><strong>".$meses[$k].": </strong></span><input ".$deshabilitado." type='text' id='mes_".$k."' value='".$dd."' /></div>";
         }
         $lista .="</div>";
         $lista .="</div>";
         echo $lista;
         break;
        endswitch;
    } catch (Exception $exc) { echo getError($exc);}  
    
     exit(); 
}
?>