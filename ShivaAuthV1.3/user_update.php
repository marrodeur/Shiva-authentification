<?php
// Nom du fichier: "user_update.php"
// Fonction: "Affiche le formulaire de modification et effectue les modifications"
// Auteur: "Pascal Viney"
// Adresse e-mail: "yapa22@free.fr"
// -------------------------------------------------------------------------------

include("user_verif.php");

//-----------------------------
// Redirection si non connecté
//-----------------------------

if( !AUTH_ID )
{
  header( 'Location: ' . URL_LOGIN );

  exit();
}


//---------------------------------------
//Affichage du formulaire de modification
//---------------------------------------

if( empty( $_GET['action'] ) and empty( $_POST['action'] ) )
{
  ?>

	<html>

	<head>
	<title>Modification du Profil</title>
	</head>

	<body>

	<center style="font-family: Verdana; font-size: 10pt;">

	<h3 style="margin-bottom: 0px;">Shiva authentification</h3>(version <?php echo $cfg['config']['version']; ?>)

	<br /><br />

	<?php echo report_disp(); ?>

	<form action="user_update.php" method="POST">

	  <input type="hidden" name="action" value="update">

	  <label>Votre Pseudo:<br><input type="text" value="<?php echo AUTH_PSEUDO; ?>" name="pseudo_set" readonly></label>
	  <br><br>
	  <label>Password actuel:<br><input type="password" name="password"></label>
	  <br><br>
	  <label>Nouveau Password:<br><input type="password" name="password_new"></label>
	  <br>
	  <label>Confirmer Password:<br><input type="password" name="password_new1"></label>
	  <br><br>
 	  <label>E-mail:<br><input type="text" name="email_modif" value="<?php echo AUTH_EMAIL; ?>"></label>
	  <br><br>

	  <input type="submit" name="send" value="Modifier">

	  <br><br>
	  <a href="<?php echo URL_REDIR; ?>">Revenir</a>

	</form>

	<?php echo ( $cfg['config']['crypt_md5'] == 1 ) ? '<br/><font style="color: '. $cfg['style']['crypt_color'] .'">'. $cfg['message']['crypt_avert'] .'</font>' : ''; ?>

	</center>

	</body>

	</html>

  <?php

  exit;
}


//-------------------------------
//Mise à jour du profil du membre
//-------------------------------

if( !empty( $_POST['action'] ) and $_POST['action'] == 'update' )
{

  /* ETAPE 1: Vérification */


    //Vérification de la conformité des variables

    $password = isset( $_POST['password'] ) ? strip_tags( $_POST['password'] ) : '';

    $password_new = isset( $_POST['password_new'] ) ? strip_tags ( $_POST['password_new'] ) : '';

    $password_new1 = isset( $_POST['password_new1'] ) ? strip_tags ( $_POST['password_new1'] ) : '';

    $email_modif = isset( $_POST['email_modif'] ) ? strtolower( $_POST['email_modif'] ) : '';


    if( empty ( $password ) or empty ( $email_modif ) )
    {
      report( $cfg['message']['no_champs'] );

      header( 'Location: ' . URL_MODIF );

      exit();
    }

    if( !empty( $password_new ) )
    {
      if( $password_new != $password_new1 )
      {
        report( $cfg['message']['no_passconf'] );

        header( 'Location: ' . URL_MODIF );

        exit();
      }
    }

  /* ETAPE 2: Modification */


    //Connexion à la Base de donnée

     $sql->open();

    //On crypte l'ancien password

      $password = ( $cfg['config']['crypt_md5'] == '1' ) ? md5( $password ) : $password;


    //On vérifie si l'ancien password correspond au pseudo

      $result = $sql->query("SELECT password FROM $sql_table WHERE pseudo='" . AUTH_PSEUDO . "' AND password='$password'");

      if( mysql_num_rows($result) == 0 )
      {
        report( $cfg['message']['no_pass'] );

	header( 'Location: ' . URL_MODIF );

	exit();
      }


    //On crypte le nouveau password

      if( !empty( $password_new ) )
      {
	$password = ( $cfg['config']['crypt_md5'] == '1' ) ? md5( $password_new ) : $password_new;
      }


    //On met à jour les coordonnées dans la base de donnée

      $sql->query("UPDATE $sql_table SET password='$password',email='$email_modif' WHERE pseudo='" . AUTH_PSEUDO . "' AND id='" . AUTH_ID . "'");


    //Fermeture de la connexion SQL

      $sql->close();


    //On affiche la confirmation
    ?>

	<html>

	<head>
	<META HTTP-EQUIV="refresh" CONTENT="<?php echo $cfg['config']['modif_timer']; ?>; URL=<?php echo URL_REDIR; ?>">
	</head>

	<body>

	<center style="font-family: Verdana; font-size: 10pt;">

	<h3 style="margin-bottom: 0px;">Shiva authentification</h3>(version <?php echo $cfg['config']['version']; ?>)

	<br /><br />

	<?php echo $cfg['message']['modif_conf']; ?>

	<br>
	<br>

	Redirection automatique dans quelques secondes...

	<br>
	<br>

	<a href="<?php echo URL_REDIR; ?>">Revenir</a>

	</center>

	</body>

	</html>

    <?php

    exit;
}

else
{
  header( 'Location: ' . URL_CREATE );

  exit();
}

?>