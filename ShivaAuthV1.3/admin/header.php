<?php
// Nom du fichier: "header.php"
// Fonction: "Eentête de l'administration"
// Auteur: "Pascal Viney"
// Adresse e-mail: "yapa22@free.fr"
// ---------------------------------------

if ( SHIVA != "true" )
{

  die ( "Internal error !" );

}

?>

<html>

<head>

  <title>Ark Membres - Administration</title>

  <link rel="stylesheet" href="class.css" type="text/css">

<style type="text/css">

.nom
{
  width: 300px;
  float: left;
  font-family: Verdana;
  font-size: 10pt;

  padding-left: 10px;
  vertical-align: middle;
}

.valeur
{
  width: 350px;
  float: left;
  font-family: Verdana;
  font-size: 10pt;
  vertical-align: middle;
}

.title
{
  float: left;
  width: 100%;
  font-family: Verdana;
  font-size: 10pt;
}

.form
{
  width: 100%;
}

 style="float: left; width: 100%;"><div style="float: left; width: 100%;">
</style>

</head>

<body bgcolor="#DBE7F2">

  <div align="center">

  <font face="Verdana" size="5"><b>Administration<br><br></font></b>

  <font face="Verdana" size="2">

    <a href="<?php echo URL_REDIR; ?>" class="adminmenu">Revenir</a> | 

    <a href="index.php" class="adminmenu">Administration Générale</a> | 

    <a href="admin_config.php" class="adminmenu">Configuration</a> | 

    <a href="admin_log.php" class="adminmenu">Fichier Log</a> | 

    <a href="admin_blacklist.php" class="adminmenu">BlackList</a>

  </font>

<p><b><font face="Verdana">

<font face="Verdana" size="2"><?php report_disp(); ?></font>