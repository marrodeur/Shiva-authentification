<?php

$sql->open();

$res = $sql->query("SELECT * FROM $sql_table_conf ORDER BY type,nom ASC");

while( $row = mysql_fetch_assoc( $res ) )
{
  $cfg[$row['type']][$row['nom']] = $row['valeur'];
}

$sql->close();

define( "URL_AUTH", $cfg['path']['url_auth'] );
define( "URL_REDIR", $cfg['path']['url_redir'] );
define( "URL_CREATE", $cfg['path']['url_create'] );
define( "URL_LOGIN", $cfg['path']['url_login'] );
define( "URL_LOGOUT", $cfg['path']['url_logout'] );
define( "URL_MODIF", $cfg['path']['url_modif'] );


?>