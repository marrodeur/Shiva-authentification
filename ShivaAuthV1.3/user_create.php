<?php 
// Nom du fichier: "user_create.php"
// Fonction: "Crée les nouveaux membres et affiche le formulaire d'inscription"
// Auteur: "Pascal Viney"
// Adresse e-mail: "yapa22@free.fr"
// ----------------------------------------------------------------------------

include('user_verif.php');


//-------------------------
// Redirection si connecté
//-------------------------

if( AUTH_ID )
{
  header( 'Location: ' . URL_LOGIN );

  exit;
}


//---------------------------------------
// Affichage du formulaire d'inscription
//---------------------------------------

if( empty( $_GET['action'] ) and empty( $_POST['action'] ) )
{
  //Affichage du formulaire d'inscription
  //Pour les utilisateurs avertis, Vous pouvez modifier les lignes
  //ci-dessous (comprises entre les commentaires)
  ?>

	<!-- Début du Formulaire -->

	<html>

	<head>
	<title>Page d'inscritpion</title>
	</head>

	<body>

	<center style="font-family: Verdana; font-size: 10pt;">

	<h3 style="margin-bottom: 0px;">Shiva authentification</h3>(version <?php echo $cfg['config']['version']; ?>)

	<br /><br />

	<?php report_disp(); ?>

	<form action="user_create.php" method="post">

	  <input type="hidden" name="action" value="add">

	  <label>Pseudo:<br><input type="text" name="pseudo"></label>
	  <br><br>
	  <label>Password:<br><input type="password" name="password"></label>
	  <br>
	  <label>Confirmer:<br><input type="password" name="password1"></label>
	  <br><br>
	  <label>E-mail:<br><input type="text" name="email"></label>
	  <br><br>

	  <input type="submit" name="send" value="S'inscrire">
	
	</form>

	<?php echo ( $cfg['config']['crypt_md5'] == 1 ) ? '<br/><font style="color: '. $cfg['style']['crypt_color'] .'">'. $cfg['message']['crypt_avert'] .'</font>' : ''; ?>

	</center>

	</body>

	</html>

	<!-- Fin du Formulaire -->

  <?php

  exit;
}


//-------------------------------
//Création du membre dans la BDD
//-------------------------------

elseif( !empty( $_POST['action'] ) and $_POST['action'] == 'add' )
{

  /* ETAPE 1: Formatage des variables */

    //Déclaration et Vérification de la conformité des variables

    $pseudo = strip_tags ( $_POST['pseudo'] );

    $password = strip_tags ( $_POST['password'] );

    $password1 = strip_tags ( $_POST['password1'] );

    $email = strtolower ( $_POST['email'] );


    if( empty( $pseudo ) or empty( $password ) or empty( $email ) )
    {
      report( $cfg['message']['no_champs'] );

      exit( header( 'Location: ' . URL_CREATE ) );
    }


    //Pseudo: longueur mini

    if( strlen( $pseudo ) < $cfg['config']['pseudo_minlen'] and $cfg['config']['pseudo_minlen'] != 0 )
    {
      report( str_replace('%min%', $cfg['config']['pseudo_minlen'], $cfg['message']['pseudo_minlen']), '' );
    }


    //Pseudo: longueur maxi

    if( strlen( $pseudo ) > $cfg['config']['pseudo_maxlen'] and $cfg['config']['pseudo_maxlen'] != 0 )
    {
      report( str_replace('%max%', $cfg['config']['pseudo_maxlen'], $cfg['message']['pseudo_maxlen']), '' );
    }


    //Password: longueur mini

    if( strlen( $password ) < $cfg['config']['pass_minlen'] and $cfg['config']['pass_minlen'] != 0 )
    {
      report( str_replace('%min%', $cfg['config']['pass_minlen'], $cfg['message']['pass_minlen']), '' );
    }


    //Password: longueur maxi 

    if( strlen( $password ) > $cfg['config']['pass_maxlen'] and $cfg['config']['pass_maxlen'] != 0 )
    {
      report( str_replace('%max%', $cfg['config']['pass_maxlen'], $cfg['message']['pass_maxlen']), '' );
    }


    if( !empty( $_SESSION['report'] ) )
    {
      exit( header( 'Location: ' . URL_CREATE ) );
    }


    if( $password != $password1 )
    {
      report( $cfg['message']['no_passconf'] );

      exit( header( 'Location: ' . URL_CREATE ) );
    }



  /* ETAPE 2: Traitement sur BDD */

    //Connexion à la base de donnée

      $sql->open();

    //On vérifie que le pseudo n'existe pas déja

      $res = $sql->query("SELECT * FROM $sql_table WHERE pseudo='$pseudo'");

      if ( mysql_num_rows($res) == 1 )
      {
	report( $cfg['message']['pseudo_exist'] );

	exit( header( 'Location: ' . URL_CREATE ) );
      }


    //Création d'un id aléatoire

      $char = 'abcdefghijklmnopqrstuvwxyz0123456789';

      srand(time()); $id = '';

      for( $i=0; $i<20; $i++ )
      {
        $id .= substr($char,(rand()%(strlen($char))),1);
      }


    //Cryptage du mot de passe (selon cfg)

      $password = ( $cfg['config']['crypt_md5'] == 1 ) ? md5( $password ) : $password;


    //Définition de l'activation du compte (selon cfg)

      $activ = ( $cfg['config']['log_user'] == 0 ) ? 'non' : 'oui';


    //Récupération de la date

      $register_date = date("d/m/Y H:i");


    //Insertion du nouveau membre et de son profil dans la BDD

      $sql->query("INSERT INTO $sql_table (pseudo,password,email,rang,id,register_date,activ) VALUES('$pseudo','$password','$email','1','$id','$register_date','$activ')");


    //Fermeture de la connexion à la BDD

      $sql->close();


  /* ETAPE 3: Confirmation */

    //Envoi du mail de confirmation si la fonction est activée

      $ac = array('non' => 'Désactivé', 'oui' => 'Activé' );

      $replace = array('pseudo' => $pseudo, 'email' => $email, 'password' => $password1, 'id' => $id, 'regdate', $register_date, 'activ' => $activ, 'activate' => $ac[$activ] );

      foreach( $replace as $key => $var )
      {
        $cfg['message']['mail_msg'] = str_replace('%'.$key.'%', $var, $cfg['message']['mail_msg']);
      }


      if( $conf_mail == '2' )
      {
	include('config/protomail/lib.protomail.php');

	protomail( $email, $cfg['message']['mail_subject'], $cfg['message']['mail_msg'] );
      }

      elseif( $conf_mail == '1' )
      {
	mail( $email, $conf_email_subject, $conf_email_msg );
      }


  //------------------------------
  // Affichage de la confirmation
  //------------------------------
  ?>

    <html>

    <head>
    <META HTTP-EQUIV="refresh" CONTENT="<?php echo $cfg['config']['register_timer']; ?>; URL=<?php echo URL_REDIR; ?>">
    </head>

    <body>

      <center style="font-family: Verdana; font-size: 10pt;">

      <h3 style="margin-bottom: 0px;">Shiva authentification</h3>(version <?php echo $cfg['config']['version']; ?>)

      <br /><br />

      <?php echo $cfg['message']['register_conf']; ?>

      <br/><br />

      Redirection automatique vers la page de connexion dans quelques secondes...

      <br/>
      <br/>

      <?php

      if( $cfg['config']['mail_type'] == 1 )
      {
	echo $cfg['message']['mail_sent'] . '<br/><br/>';
      }

      elseif( $cfg['config']['mail_type'] == 2 )
      {
	echo $cfg['message']['mailt_sentproto'] . '<br/><br/>';
      }

      ?>

      <a href="<?php echo URL_LOGIN; ?>">S'identifier</a>

    </center>

    </html></body>


  <?php

  session_destroy();

  exit;
}

else
{
  header( 'Location: ' . URL_CREATE );

  exit;
}
?>