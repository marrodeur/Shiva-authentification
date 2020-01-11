<?php

//---------------------------------------------------------------------------------
// Nom du fichier: "user_login.php"
// Fonction: "Connecte/déconnecte les membres et affiche le formulaire de connexion
// Auteur: "Pascal Viney"
// Adresse e-mail: "yapa22@free.fr"
// --------------------------------------------------------------------------------

include('user_verif.php');


//----------------------------------------
// Affiche le formulaire d'identification 
//----------------------------------------

if( empty( $_GET['action'] ) and empty( $_POST['action'] ) and !AUTH_ID )
{
  //Affichage du formulaire de connexion
  //Pour les utilisateurs avertis, Vous pouvez modifier les lignes
  //ci-dessous (comprises entre les commentaires)

  ?>

	<!-- Début du Formulaire -->


	<html>

	<head><title>Connexion</title></head>	

	<body>

	<center style="font-family: Verdana; font-size: 10pt;">

	<h3 style="margin-bottom: 0px;">Shiva authentification</h3>(version <?php echo $cfg['config']['version']; ?>)

	<br /><br />

	<?php report_disp(); ?>

	<form action="user_login.php" method="post">

	  <input type="hidden" name="action" value="verif">

	  <label>Pseudo:<br><input type="text" name="pseudo"></label><br>
	  <label>Password:<br><input type="password" name="password"></label><br><br>

	  <input type="submit" value="Connexion">

	  <br><br>
	  <a href="<?php echo URL_CREATE; ?>" title="S'inscrire">S'inscrire</a>

	</form>

	</center>

	</body>

	</html>

	<!-- Fin du Formulaire -->

  <?php

  exit();
}

//------------------------
// Logout de l'utilisateur
//------------------------

elseif( !empty( $_GET['action'] ) and $_GET['action'] == 'logout' and AUTH_ID )
{
  session_destroy();

  header( 'Location: ' . URL_REDIR );

  exit();
}

//-------------------------------
// Identification de l'utilsateur
//-------------------------------

elseif( !empty( $_POST['action'] ) and $_POST['action'] == 'verif' and !AUTH_ID )
{
  //On défini les variables

    $pseudo = isset( $_POST['pseudo'] ) ? strip_tags( $_POST['pseudo'] ) : '';

    $password = isset( $_POST['password'] ) ?  strip_tags( $_POST['password'] ) : '';


  //On vérifie

    if( empty( $pseudo ) or empty( $password ) )
    {
      report( $cfg['message']['no_champs'] );

      header( 'Location: ' . URL_LOGIN );

      exit();
    }

  //Cryptage selon config

    $password = (  $cfg['config']['crypt_md5'] == '1' ) ? md5( $password ) : $password;


  //Connexion à la Base de donnée

  $sql->open();


  //Vérification auprès de la base de donnée

    $res = $sql->query("SELECT activ,id FROM $sql_table WHERE pseudo='$pseudo' AND password='$password' LIMIT 0,1");

    if ( mysqli_num_rows($res) != "1" )
    {
      report( $cfg['message']['no_pass'] );

      header( 'Location: ' . URL_LOGIN );

      exit();
    }

    $row = mysqli_fetch_array($res);

    if ( $row['activ'] == "non" )
    {
      report( $cfg['message']['compte_desactive'] );

      header( 'Location: ' . URL_LOGIN );

      exit();
    }

    if ( $row['activ'] == "black" )
    {
      report( $cfg['message']['compte_blacklist'] );

      exit( header( 'Location: ' . URL_LOGIN ) );
    }

    //On extrait l'id correspondant au pseudo et au mot de passe

      $_SESSION['id'] = $row['id'];


  //Fermeture de la connexion SQL

  $sql->close();


  //Redirection en fonction de la configuration

  if(  $cfg['config']['log_user'] == '1' )
  { 
    header('Location: admin/log.php');
  }

  else
  {
    header( 'Location: ' . URL_REDIR );
  }

  exit();
}


//-------------------------
// Redirection si connecté
//-------------------------

else
{
  header( 'Location: ' . URL_LOGIN );

  exit();
}

// Affiche le formulaire d'identification 
//----------------------------------------

if( empty( $_GET['action'] ) and empty( $_POST['action'] ) and !AUTH_ID )
{
  //Affichage du formulaire de connexion
  //Pour les utilisateurs avertis, Vous pouvez modifier les lignes
  //ci-dessous (comprises entre les commentaires)

  ?>

	<!-- Début du Formulaire -->


	<html>

	<head><title>Connexion</title></head>	

	<body>

	<center style="font-family: Verdana; font-size: 10pt;">

	<h3 style="margin-bottom: 0px;">Shiva authentification</h3>(version <?php echo $cfg['config']['version']; ?>)

	<br /><br />

	<?php report_disp(); ?>

	<form action="user_login.php" method="post">

	  <input type="hidden" name="action" value="verif">

	  <label>Pseudo:<br><input type="text" name="pseudo"></label><br>
	  <label>Password:<br><input type="password" name="password"></label><br><br>

	  <input type="submit" value="Connexion">

	  <br><br>
	  <a href="<?php echo URL_CREATE; ?>" title="S'inscrire">S'inscrire</a>

	</form>

	</center>

	</body>

	</html>

	<!-- Fin du Formulaire -->

  <?php

  exit();
}

//------------------------
// Logout de l'utilisateur
//------------------------

elseif( !empty( $_GET['action'] ) and $_GET['action'] == 'logout' and AUTH_ID )
{
  session_destroy();

  header( 'Location: ' . URL_REDIR );

  exit();
}

//-------------------------------
// Identification de l'utilsateur
//-------------------------------

elseif( !empty( $_POST['action'] ) and $_POST['action'] == 'verif' and !AUTH_ID )
{
  //On défini les variables

    $pseudo = isset( $_POST['pseudo'] ) ? strip_tags( $_POST['pseudo'] ) : '';

    $password = isset( $_POST['password'] ) ?  strip_tags( $_POST['password'] ) : '';


  //On vérifie

    if( empty( $pseudo ) or empty( $password ) )
    {
      report( $cfg['message']['no_champs'] );

      header( 'Location: ' . URL_LOGIN );

      exit();
    }

  //Cryptage selon config

    $password = (  $cfg['config']['crypt_md5'] == '1' ) ? md5( $password ) : $password;


  //Connexion à la Base de donnée

  $sql->open();


  //Vérification auprès de la base de donnée

    $res = $sql->query("SELECT activ,id FROM $sql_table WHERE pseudo='$pseudo' AND password='$password' LIMIT 0,1");

    if ( mysqli_num_rows($res) != "1" )
    {
      report( $cfg['message']['no_pass'] );

      header( 'Location: ' . URL_LOGIN );

      exit();
    }

    $row = mysqli_fetch_array($res);

    if ( $row['activ'] == "non" )
    {
      report( $cfg['message']['compte_desactive'] );

      header( 'Location: ' . URL_LOGIN );

      exit();
    }

    if ( $row['activ'] == "black" )
    {
      report( $cfg['message']['compte_blacklist'] );

      exit( header( 'Location: ' . URL_LOGIN ) );
    }

    //On extrait l'id correspondant au pseudo et au mot de passe

      $_SESSION['id'] = $row['id'];


  //Fermeture de la connexion SQL

  $sql->close();


  //Redirection en fonction de la configuration

  if(  $cfg['config']['log_user'] == '1' )
  { 
    header('Location: admin/log.php');
  }

  else
  {
    header( 'Location: ' . URL_REDIR );
  }

  exit();
}


//-------------------------
// Redirection si connecté
//-------------------------

else
{
  header( 'Location: ' . URL_LOGIN );

  exit();
}

?>