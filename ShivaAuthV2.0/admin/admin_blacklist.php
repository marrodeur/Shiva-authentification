<?php
// Nom du fichier: "admin_blacklist.php"
// Fonction: "Panneau d'administration de la blacklist"
// Auteur: "Pascal Viney"
// Adresse e-mail: "yapa22@free.fr"
// ------------------------------------------------

include('../user_verif.php');


//-------------------------
// Vérification des droits
//-------------------------

if( !AUTH_ID or AUTH_RANG < 3 )
{
  header( 'Location: ' . URL_REDIR );

  exit;
}


if( empty( $_GET['action'] ) )
{

  //En-tête de la page

  define ("SHIVA", "true");

  include('header.php');

  ?>

  <br>Blacklist :</font></b></p>

  <font face="Verdana" size="1">

  <img src="retirer.gif" title="Retirer de la BlackList" border="0"> = Retirer de la Blacklist &nbsp;&nbsp;&nbsp;

  <img src="supprimer.gif" title="Supprimer définitivement" border="0"> = Supprimer

  </font>

  <table border="0" cellpadding="0" cellspacing="0" width="80%" id="table1">
	<tr>
		<td style="border-left: 1px solid #000000; border-top: 1px solid #000000" bgcolor="#81ABD1" align="center">
		<b><font face="Verdana" size="2">Pseudo</font></b></td>
		<td style="border-left-style: dotted; border-left-width: 1px; border-top: 1px solid #000000" bgcolor="#81ABD1" align="center" width="140">
		<b><font face="Verdana" size="2">Email</font></b></td>
		<td style="border-left-style: dotted; border-left-width: 1px; border-top: 1px solid #000000" bgcolor="#81ABD1" align="center" width="100">
		<b><font face="Verdana" size="2">Rang</font></b></td>
		<td style="border-left-style: dotted; border-left-width: 1px; border-top: 1px solid #000000" bgcolor="#81ABD1" align="center" width="180">
		<b><font face="Verdana" size="2">Date d'enregistrement</font></b></td>
		<td style="border-left-style: dotted; border-left-width: 1px; border-top: 1px solid #000000" bgcolor="#81ABD1" align="center" width="200">
		<b><font face="Verdana" size="2">id</font></b></td>
		<td style="border-left-style: dotted; border-left-width: 1px; border-top: 1px solid #000000" bgcolor="#81ABD1" align="center" width="60">
		<b><font face="Verdana" size="2">Activé</font></b></td>
		<td style="border-left-style: dotted; border-left-width: 1px; border-right: 1px solid #000000; border-top: 1px solid #000000" bgcolor="#81ABD1" align="center" width="80">
		<b><font face="Verdana" size="2">Action</font></b></td>
	</tr>

  <?php

  //Connexion à la Base de donnée

    $sql->open();


  //Requête

    $result = $sql->query("SELECT * FROM $sql_table WHERE activ='black' ORDER By rang DESC");

    while( $row = mysqli_fetch_array( $result ) )
    {
	$admin_id = nl2br ( $row['id']);

	$admin_pseudo = nl2br ( $row['pseudo'] );

	$admin_email = nl2br ( $row['email'] );

	$admin_rang = nl2br ( $row['rang'] );

	$admin_register = nl2br ( $row['register_date'] );

	$admin_activ = nl2br ( $row['activ'] );


	if ( $admin_rang == "1" ) { $set_rang = "Membre"; $td_color = ""; }

	if ( $admin_rang == "2" ) { $set_rang = "Modérateur"; $td_color =""; }

	if ( $admin_rang == "3" ) { $set_rang = "Administrateur"; $td_color = ""; }

	if ( $admin_activ = "black" ) { $admin_activ = "BlackList"; }


	$td_color = 'bgcolor="#EAEAEA"';

	$img  = '<a href="admin_user.php?action=activ&user='.$admin_id.'"><img src="retirer.gif" title="Retirer de la BlackList" border="0"></a>';

	$imgs = '<a href="admin_user.php?action=suppr&user='.$admin_id.'"><img src="supprimer.gif" title="Supprimer définitivement" border="0"></a>';

	echo '<tr>
		<td '.$td_color.' align="center" style="border-left: 1px solid #000000; border-bottom: 1px solid #DBE7F2" bgcolor="#FFFFFF"><font face="Verdana" size="2"><b>'.$admin_pseudo.'</b></font></td>
		<td '.$td_color.' align="center" style="border-left-style: dotted; border-left-width: 1px; border-bottom: 1px solid #DBE7F2" bgcolor="#FFFFFF"><font face="Verdana" size="2"><a href="mailto: '.$admin_email.'" class="adminmenu">'.$admin_email.'</a></font></td>
		<td '.$td_color.' align="center" style="border-left-style: dotted; border-left-width: 1px; border-bottom: 1px solid #DBE7F2" bgcolor="#FFFFFF"><font face="Verdana" size="2">'.$set_rang.'</font></td>
		<td '.$td_color.' align="center" style="border-left-style: dotted; border-left-width: 1px; border-bottom: 1px solid #DBE7F2" bgcolor="#FFFFFF"><font face="Verdana" size="2">'.$admin_register.'</font></td>
		<td '.$td_color.' align="center" style="border-left-style: dotted; border-left-width: 1px; border-bottom: 1px solid #DBE7F2" bgcolor="#FFFFFF"><font face="Verdana" size="2">'.$admin_id.'</font></td>
		<td '.$td_color.' align="center" style="border-left-style: dotted; border-left-width: 1px; border-bottom: 1px solid #DBE7F2" bgcolor="#FFFFFF"><font face="Verdana" size="2">'.$admin_activ.'</font></td>
		<td '.$td_color.' align="center" style="border-left-style: dotted; border-left-width: 1px; border-right: 1px solid #000000; border-bottom: 1px solid #DBE7F2" bgcolor="#FFFFFF"><font face="Verdana" size="2">'.$img.' &nbsp;'.$imgs.'</font></td>
	     </tr>';

    }


    //Fin du tableau

    ?>

	      <tr>
		<td style="border-left: 1px solid #000000; border-bottom: 1px solid #000000" bgcolor="#FFFFFF">&nbsp;</td>
		<td style="border-left-style: dotted; border-left-width: 1px; border-bottom: 1px solid #000000" bgcolor="#FFFFFF">&nbsp;</td>
		<td style="border-left-style: dotted; border-left-width: 1px; border-bottom: 1px solid #000000" bgcolor="#FFFFFF">&nbsp;</td>
		<td style="border-left-style: dotted; border-left-width: 1px; border-bottom: 1px solid #000000" bgcolor="#FFFFFF">&nbsp;</td>
		<td style="border-left-style: dotted; border-left-width: 1px; border-bottom: 1px solid #000000" bgcolor="#FFFFFF">&nbsp;</td>
		<td style="border-left-style: dotted; border-left-width: 1px; border-bottom: 1px solid #000000" bgcolor="#FFFFFF">&nbsp;</td>
		<td style="border-left-style: dotted; border-left-width: 1px; border-right: 1px solid #000000; border-bottom: 1px solid #000000" bgcolor="#FFFFFF">&nbsp;</td>
	      </tr>
      </table></div>

    </body>

    </html>

    <?php

    //On ferme la connexion SQL

      $sql->close();

      exit;
}

else
{
  header('Location: admin_user.php');
}
?>