<?php
// Nom du fichier: "log.php"
// Fonction: "Inscrit les utilisateur dans un fichier log"
// Auteur: "Pascal Viney"
// Adresse e-mail: "yapa22@free.fr"
// -------------------------------------------------------

include('../user_verif.php');


//----------------------
// Log de l'utilisateur
//----------------------

$logfile = 'logs/log_result.txt';

if( !file_exists( $logfile ) )
{
  fclose( fopen( $logfile, 'w') );
}


$rien = 'NC'; $sep = ' ; ';


$ipclient 	= !empty( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : $rien; 		//ip du client

$hostclient 	= !empty( $_SERVER['REMOTE_HOST'] ) ? $_SERVER['REMOTE_HOST'] : $rien; 		//Host du client (pas tjrs dispo)

$idd 		= !empty( $_SERVER['QUERY_STRING'] ) ? $_SERVER['QUERY_STRING'] : $rien; 	//Var inter pages

$method 	= !empty( $_SERVER['REQUEST_METHOD'] ) ? $_SERVER['REQUEST_METHOD'] : $rien; 	//Methode de requete http
    
$from 		= !empty( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : $rien; 	//Adresse de la page precedente

$in 		= !empty( $_SERVER['SCRIPT_NAME'] ) ? $_SERVER['SCRIPT_NAME'] : $rien; 		//adresse de la page apartir de racine du site

$date 		= strftime('%d/%m/%Y %H:%M'); 							// Date


$input 	= $date . $sep;
$input .= $hostclient . $sep;
$input .= $ipclient . $sep;
$input .= $from . $sep;
$input .= $in . $sep;
$input .= AUTH_PSEUDO . $sep;
$input .= $method . "\n";


$f = fopen( $logfile,'a' );

fputs( $f, $input );

fclose( $f );


//-------------
// Redirection
//-------------

header( 'Location: ' . URL_REDIR );

exit;

?>