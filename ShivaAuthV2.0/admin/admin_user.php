<?php
// Nom du fichier: "admin_user.php"
// Fonction: "Panneau d'administration des membres"
// Auteur: "Pascal Viney"
// Adresse e-mail: "yapa22@free.fr"
// ------------------------------------------------

include('../user_verif.php');


//------------------------------------
// Affiche le panneau d'administration
//------------------------------------

if( !AUTH_ID or AUTH_RANG < 3 )
{
  header( 'Location: ' . URL_REDIR );

  exit();
}

if( empty( $_GET['action'] ) )
{

  //En-tête de la page

  define ("SHIVA", "true");

  include('header.php');

  ?>

	<br>Liste des Membres :</font></b></p>

	<font face="Verdana" size="1">

	  <img src="desactiver.gif" title="Désactivation du compte" border="0"> = Désactiver compte &nbsp;&nbsp;&nbsp;

	  <img src="activer.gif" title="Activation du compte" border="0"> = Activer compte &nbsp;&nbsp;&nbsp;

	  <img src="blacklist.gif" title="Transférer dans la BlackList" border="0"> = Transférer dans la BlackList &nbsp;&nbsp;&nbsp;

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
		<b><font face="Verdana" size="2">Enregistré le</font></b></td>

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


	//Requête SQL

	$result = $sql->query("SELECT * FROM $sql_table WHERE activ='oui' OR activ='non' ORDER By rang DESC");


	//Extraction et traitement

	while( $row = mysqli_fetch_array( $result ) )
	{
	  $admin_id = nl2br ( $row['id'] );

	  $admin_pseudo = nl2br ( $row['pseudo'] );

	  $admin_email = nl2br ( $row['email'] );

	  $admin_rang = nl2br ( $row['rang'] );

	  $admin_register = nl2br ( $row['register_date'] );

	  $admin_activ = nl2br ( $row['activ'] );


	  //Identification du rang

	    $r1 = '<a href="admin_user.php?action=prom&setrang=1&user='.$admin_id.'">1</a>';

	    $r2 = '<a href="admin_user.php?action=prom&setrang=2&user='.$admin_id.'">2</a>';

	    $r3 = '<a href="admin_user.php?action=prom&setrang=3&user='.$admin_id.'">3</a>';

	    if ( $admin_rang == "4" )
	    {
	 	$td_color = 'bgcolor="#FFE1E1"'; $defrang = 'Super-Admin';
	    }

	    else
	    {
	      if ( $admin_rang == "3" )
	      {
		$td_color = 'bgcolor="#FFE1E1"'; $r3 = '3';
	      }

	      elseif ( $admin_rang == "2" )
	      {
		$td_color = 'bgcolor="#CCFFCC"'; $r2 = '2';
	      }

	      elseif ( $admin_rang == "1" )
	      {
		$td_color = ''; $r1 = '1';
	      }

	      $defrang = "$r1&nbsp; &nbsp;$r2&nbsp; &nbsp$r3";
	    }

	  //Gestion des actions disponibles

	  if($admin_activ == "oui")
	  {
	    $img = '<a href="admin_user.php?action=desactiv&user='.$admin_id.'"><img src="desactiver.gif" title="Désactivation du compte" border="0"></a>';
	  }

	  elseif($admin_activ == "non")
	  {
	    $img = '<a href="admin_user.php?action=activ&user='.$admin_id.'"><img src="activer.gif" title="Activation du compte" border="0"></a>';
	  }

	  $img_b = '<a href="admin_user.php?action=black&user='.$admin_id.'"><img src="blacklist.gif" title="Transférer dans la BlackList" border="0"></a>';

	  $img_s = '<a href="admin_user.php?action=suppr&user='.$admin_id.'"><img src="supprimer.gif" title="Supprimer définitivement" border="0"></a>';

	  $b1 = ''; $b2 = '';

	  if( $admin_rang == '4' )
	  {
	    $b1 = '<span style="color: red">';
	    $b2 = '</span>';
	  }

	  echo '<tr>
		<td '.$td_color.' align="center" style="border-left: 1px solid #000000; border-bottom: 1px solid #DBE7F2" bgcolor="#FFFFFF"><font face="Verdana" size="2"><b>'.$b1.$admin_pseudo.$b2.'</b></font></td>
		<td '.$td_color.' align="center" style="border-left-style: dotted; border-left-width: 1px; border-bottom: 1px solid #DBE7F2" bgcolor="#FFFFFF"><font face="Verdana" size="2"><a href="mailto: '.$admin_email.'" class="adminmenu">'.$admin_email.'</a></font></td>
		<td '.$td_color.' align="center" style="border-left-style: dotted; border-left-width: 1px; border-bottom: 1px solid #DBE7F2" bgcolor="#FFFFFF"><font face="Verdana" size="1">'.$defrang.'</font>
		<td '.$td_color.' align="center" style="border-left-style: dotted; border-left-width: 1px; border-bottom: 1px solid #DBE7F2" bgcolor="#FFFFFF"><font face="Verdana" size="2">'.$admin_register.'</font></td>
		<td '.$td_color.' align="center" style="border-left-style: dotted; border-left-width: 1px; border-bottom: 1px solid #DBE7F2" bgcolor="#FFFFFF"><font face="Verdana" size="2">'.$admin_id.'</font></td>
		<td '.$td_color.' align="center" style="border-left-style: dotted; border-left-width: 1px; border-bottom: 1px solid #DBE7F2" bgcolor="#FFFFFF"><font face="Verdana" size="2">'.$admin_activ.'</font></td>
		<td '.$td_color.' align="center" style="border-left-style: dotted; border-left-width: 1px; border-right: 1px solid #000000; border-bottom: 1px solid #DBE7F2" bgcolor="#FFFFFF"><font face="Verdana" size="2">'.$img.' &nbsp;'.$img_b.' &nbsp;'.$img_s.'</font></td>
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
	</table>

	</div>

  </body>

  </html>

  <?php


  //On ferme la connexion SQL

  $sql->close();

  exit;
}


//----------------------------------------------------
// Activation/Désactivation/Blacklist d'un Utilisateur
//----------------------------------------------------

elseif ( $_GET['action'] == 'activ' or $_GET['action'] == 'desactiv' or $_GET['action'] == 'black' )
{
  $user = $_GET['user'];

  $action = $_GET['action'];


  if ( empty( $user ) )
  {
    report('Aucun pseudo spécifié !');

    exit( header('Location: admin_user.php') );
  }

  if ( $action == 'activ' )
  {
    $activ = 'oui'; $ok = 'activé';
  }

  elseif ( $action == 'desactiv' )
  {
    $activ = 'non'; $ok = 'désactivé';
  }

  elseif ( $action == 'black' )
  {
    $activ = 'black'; $ok = 'ajouté à la BlackList';
  }

  else
  {
    report('Aucune action valide spécifiée!');

    exit( header('Location: admin_user.php') );
  }



  //Connexion à la Base de donnée

    $sql->open();


  //On vérifie si le pseudo existe

    $result = $sql->query("SELECT pseudo,rang FROM $sql_table WHERE id='$user'");


    if ( mysqli_num_rows( $result ) != 1 )
    {
      report('Pseudo introuvable ou inexistant !');

      exit( header('Location: admin_user.php') );
    }

    $row = mysqli_fetch_assoc( $result );

    if( ( $row['rang'] == 3 and AUTH_RANG != 4 ) or $row['rang'] == 4 )
    {
      report('Vous n\'avez pas les droits nécéssaire !');

      exit( header('Location: admin_user.php') );
    }


  // Update du membre

    $sql->query("UPDATE $sql_table SET activ='$activ' WHERE id='$user'");


  //On ferme la connexion SQL

    $sql->close();


  //Redirection vers le panneau d'administration

    report('L\'utilisateur "'.$row['pseudo'].'" a bien été '.$ok.' !');

    exit( header("Location: admin_user.php") );
}


//---------------------------------------
// Modification du rang d'un utilisateur
//---------------------------------------

elseif( $_GET['action'] == 'prom' and !empty ( $_GET['setrang'] ) and !empty ( $_GET['user'] ) )
{

  //Initialisation des variables

    $setrang = $_GET['setrang'];

    $user = $_GET['user'];

  if ( $setrang == "1" or $setrang == "2" or $setrang == "3" )
  { 

    //Connexion à la Base de donnée

      $sql->open();

    //On vérifie si le pseudo existe

      $result = $sql->query("SELECT pseudo,rang FROM $sql_table WHERE id='$user'");

      if( mysqli_num_rows($result) != 1 )
      {
        report('Pseudo introuvable ou inexistant !');

        exit( header('Location: admin_user.php') );
      }

      $row = mysqli_fetch_assoc( $result );


      if( ( $row['rang'] == 3 and AUTH_RANG != 4 ) or $row['rang'] == 4 )
      {
	report('Vous n\'avez pas les droits nécéssaire !');

	exit( header('Location: admin_user.php') );
      }


      $sql->query("UPDATE $sql_table SET rang='$setrang' WHERE id='$user'");


    //On ferme la connexion SQL

      $sql->close();


    //Définition du rang

      if( $setrang == '1' )
      { 
	$c = 'Utilisateur';
      }

      elseif( $setrang == '2' )
      {
	$c = 'Modérateur';
      }

      elseif( $setrang == '3')
      {
	$c = 'Administrateur';
      }

    //Redirection vers le panneau d'administration

      report('L\'utilisateur "'.$row['pseudo'].'" est désormais <b>'.$c.'</b> !');

      exit( header("Location: admin_user.php") );
  }

  else
  {
    report('Numéro de rang invalide !');

    exit( header("Location: admin_user.php") );
  }

}


//------------------------------
// Suppression d'un utilisateur
//------------------------------

elseif ( $_GET['action'] == 'suppr' and !empty ( $_GET['user'] ) )
{

  $user = $_GET['user'];

  //Connexion à la Base de donnée

    $sql->open();


  //On vérifie si le pseudo existe

    $result = $sql->query("SELECT pseudo,rang FROM $sql_table WHERE id='$user'");

    if( mysqli_num_rows($result) != '1' )
    {
      report('Pseudo introuvable ou inexistant !');

      exit( header('Location: admin_user.php') );
    }

    $row = mysqli_fetch_assoc( $result );


    if( ( $row['rang'] == 3 and AUTH_RANG != 4 ) or $row['rang'] == 4 )
    {
      report('Vous n\'avez pas les droits nécéssaire !');

      exit( header('Location: admin_user.php') );
    }


    $sql->query("DELETE FROM $sql_table WHERE id='$user'");


  //On ferme la connexion SQL

    $sql->close();


  //Redirection vers le panneau d'administration

    report('L\'utilisateur "'.$row['pseudo'].'" a bien été supprimé!');

    exit( header('Location: admin_user.php') );
}

//------------------------------------------------------
// Redirection si l'utilisateur n'est pas administrateur
//------------------------------------------------------

else
{
  exit( header("Location: $url_redir") );
}

?>