<?php
// Nom du fichier: "admin_log.php"
// Fonction: "Panneau d'administration du fichier log"
// Auteur: "Pascal Viney"
// Adresse e-mail: "yapa22@free.fr"
// ------------------------------------------------

include('../user_verif.php');

//-----------------------
// Affiche le fichier log
//-----------------------

if( !AUTH_ID or AUTH_RANG < 3 )
{
  header( 'Location: ' . URL_REDIR );

  exit;
}


if( empty( $_GET['act'] ) )
{

  //En-tête de la page

  define ("SHIVA", "true");

  include('header.php');

  ?>


  <br>Affichage du log :</font></b></p>

  <br>


  <?php

  if ( file_exists('log_result.txt') )

  {

    ?>


    <font face="Verdana" size="2">

    <table border="0" cellpadding="0" cellspacing="0" width="80%" id="table2">
	<tr>
		<td style="border-left: 1px solid #000000; border-top: 1px solid #000000" bgcolor="#81ABD1" align="center">
		<b><font face="Verdana" size="2">Date</font></b></td>

		<td style="border-left-style: dotted; border-left-width: 1px; border-top: 1px solid #000000" bgcolor="#81ABD1" align="center" width="100">
		<b><font face="Verdana" size="2">Client</font></b></td>

		<td style="border-left-style: dotted; border-left-width: 1px; border-top: 1px solid #000000" bgcolor="#81ABD1" align="center" width="120">
		<b><font face="Verdana" size="2">Ip</font></b></td>

		<td style="border-left-style: dotted; border-left-width: 1px; border-top: 1px solid #000000" bgcolor="#81ABD1" align="center" width="180">
		<b><font face="Verdana" size="2">Provenance</font></b></td>

		<td style="border-left-style: dotted; border-left-width: 1px; border-top: 1px solid #000000" bgcolor="#81ABD1" align="center" width="200">
		<b><font face="Verdana" size="2">Page appellée</font></b></td>

		<td style="border-left-style: dotted; border-left-width: 1px; border-top: 1px solid #000000" bgcolor="#81ABD1" align="center" width="100">
		<b><font face="Verdana" size="2">Pseudo</font></b></td>

		<td style="border-left-style: dotted; border-left-width: 1px; border-right: 1px solid #000000; border-top: 1px solid #000000" bgcolor="#81ABD1" align="center" width="80">
		<b><font face="Verdana" size="2">Méthode</font></b></td>
	</tr>
	<tr>
		<td align="center" style="border-left: 1px solid #000000; border-right: 1px solid #000000; border-bottom: 1px solid #DBE7F2" bgcolor="#FFFFFF"><font face="Verdana" size="1">

    <?php

	$fcontents = file("logs/log_result.txt");

	while ( list( $line_num, $line ) = each( $fcontents ) )
	{

	  $td_deb = '</td><td align="center" style="border-right: 1px solid #000000; border-bottom: 1px solid #DBE7F2" bgcolor="#FFFFFF"><font face="Verdana" size="1">';

	  $td_fin = '</td></tr><tr><td align="center" style="border-left: 1px solid #000000; border-right: 1px solid #000000; border-bottom: 1px solid #DBE7F2" bgcolor="#FFFFFF"><font face="Verdana" size="1">';


	  $line = ereg_replace(";", $td_deb, $line);

	  echo $line.$td_fin;

	}

    ?>

		</td>
	</tr>
	<tr>
		<td style="border-right: 1px solid #000000; border-left: 1px solid #000000; border-bottom: 1px solid #000000" bgcolor="#FFFFFF">&nbsp;</td>

		<td style="border-right: 1px solid #000000; border-bottom: 1px solid #000000" bgcolor="#FFFFFF">&nbsp;</td>

		<td style="border-right: 1px solid #000000; border-bottom: 1px solid #000000" bgcolor="#FFFFFF">&nbsp;</td>

		<td style="border-right: 1px solid #000000; border-bottom: 1px solid #000000" bgcolor="#FFFFFF">&nbsp;</td>

		<td style="border-right: 1px solid #000000; border-bottom: 1px solid #000000" bgcolor="#FFFFFF">&nbsp;</td>

		<td style="border-right: 1px solid #000000; border-bottom: 1px solid #000000" bgcolor="#FFFFFF">&nbsp;</td>

		<td style="border-right: 1px solid #000000; border-bottom: 1px solid #000000" bgcolor="#FFFFFF">&nbsp;</td>
	</tr>
    </table>

    <table align="center" border="0" width="80%">
	<tr align="right">
		<td border="0" width="100%" align="right"><font size="1"><a href="admin_log.php?act=vider" class="adminmenu">Vider le fichier log</a></font></td>
	</tr>
    </table>

  </font>

  <?php

  }

  else
  {

  echo '<font face="Verdana" size="2"><i>Fichier log vide !</i></font>';

  }

  ?>

  </body>

  <html>

  <?php

  exit;

}

elseif( !empty( $_GET['act'] ) and $_GET['act'] == 'vider' )
{
  copy('log_result.txt','logs/' . time() . '.log');

  unlink('log_result.txt');

  header( 'Location: admin_log.php' );

  exit();
}

else
{
  header( 'Location: admin_user.php' );

  exit();
}

?>