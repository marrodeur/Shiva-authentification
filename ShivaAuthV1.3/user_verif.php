<?php
// Nom du fichier: "page_verif.php"
// Fonction: "Contr�le si le visiteur est identifi� ou non"
// Auteur: "Pascal Viney"
// Adresse e-mail: "yapa22@free.fr"
// --------------------------------------------------------

//
// Le script de cette page est � inclure dans les pages � prot�ger
// � l'aide du code "include('user_verif.php);", en adaptant
// le chemin � celui du script.
//

session_start();

// V�rification et inclusion des fichiers de configuration

if( !include('config/config.php') )
{
  exit('Le fichier "config.php" est introuvable !');
}


if( !include('config/fonctions.php') )
{
  exit('Le fichier "fonctions.php" est introuvable !');
}


if( !include('config/commun.php') )
{
  exit('Le fichier "commun.php" est introuvable !');
}


//On v�rifie si l'id existe

$defaut = 'true';

if( !empty( $_SESSION['id'] ) )
{
  $sql->open();

  $result = $sql->query("SELECT * FROM $sql_table WHERE id='{$_SESSION['id']}'");

  if ( mysql_num_rows($result) == 0 )
  {
    unset( $_SESSION['id'] );
  }

  else
  {
    //On extrait le pseudo, l'email, le rang et l'etat d'activation correspondant � l'id

      $row = mysql_fetch_array($result);

      define( "AUTH_ID", $_SESSION['id'] );

      define( "AUTH_PSEUDO", $row['pseudo'] );

      define( "AUTH_EMAIL", $row['email'] );

      define( "AUTH_RANG", $row['rang'] );

      define( "AUTH_REGDATE", $row['register_date'] );

      $defaut = 'false';


    //V�rification de l'�tat du compte

      if( $row['activ'] == 'non' )
      {
	session_destroy();

	report('Votre compte est d�sactiv� !');

	header( 'Location: ' . URL_LOGIN );

	exit;
      }

      if ( $row['activ'] == 'black' )
      {
        report('Votre compte est plac� sur la BlackList !');

        header( 'Location: ' . URL_LOGIN );

        exit;
      }
  }

    $sql->close();
}

if( $defaut == 'true' )
{
      define( "AUTH_ID", false);

      define( "AUTH_PSEUDO", "" );

      define( "AUTH_EMAIL", "" );

      define( "AUTH_RANG", "0" );

      define( "AUTH_REGDATE", "" );
}

?>