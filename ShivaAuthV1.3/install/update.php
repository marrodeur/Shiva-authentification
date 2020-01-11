<?php

session_start();

include('../config/config.php');

if (!isset($conf_crypt))
{
  ?>

<html>

<head>
  <title>Update Shiva Auth 1.3 test - Erreur</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="conteneur">

  <div id="entete">

    <h1>Erreur</h1>

    Update impossible

  </div>

  <div id="centre">

    Votre script n'est pas Updatable!<br /><br />
    V�rifiez que vous n'avez rien modifi� dans le fichier "config.php" ou que vous n'avez pas d�ja updat� le script.<br /><br />

    <a href="index.php">Retour</a>

  </div>

  <div id="bas">

    Shiva Authentification version 1.3 (test) - License GPL

  </div>

</div>

</body>

</html>


  <?php

  exit();
}

$sql->open();

if (isset($_POST['update']) and isset($_POST['update_path']) and isset($_POST['update_tableconf']))
{
  $_SESSION['update_pseudo'] = $_POST['update_pseudo'];
  $_SESSION['update_pass'] = $_POST['update_pass'];
  $_SESSION['update_email'] = $_POST['update_email'];
  $_SESSION['update_tableconf'] = $_POST['update_tableconf'];
  $_SESSION['update_path'] = $_POST['update_path'];

  $sql->query("DROP TABLE IF EXISTS {$_SESSION['update_tableconf']}");

  $req = "CREATE TABLE {$_SESSION['update_tableconf']} (`type` varchar(50) NOT NULL default '',`nom` varchar(50) NOT NULL default '',`valeur` text NOT NULL)";
  $sql->query($req);

  $tab = array(
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('message', 'no_champs', 'Remplissez tout les champs !');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('message', 'no_pass', 'Pseudo ou password incorrect !');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('message', 'compte_desactive', 'Votre compte est d�sactiv� !');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('message', 'compte_blacklist', 'Votre compte est plac� sur la BlackList !');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('message', 'no_passold', 'Votre mot de passe ne doit pas d�passer %max% caract�res');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('message', 'no_passconf', 'Confirmation de votre mot de passe incorrecte !');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('message', 'mail_sent', 'Un e-mail vous a �t� envoy� avec vos identifiants de connexion');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('message', 'mail_sentproto', 'Un e-mail vous a �t� envoy� avec vos identifiants de connexion (avec <a href=\"http://samuel.kabak.free.fr\" target=\"blank\">Protomail</a>)');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('message', 'register_conf', 'Votre inscription s\'est effectu�e avec succ�s !');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('message', 'modif_conf', 'La modification de votre profil s\'est effectu�e avec succ�s !');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('style', 'crypt_color', '#A3A3A3');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('message', 'crypt_avert', 'Attention, le password est crypt� et ne peut pas �tre r�cup�r� !');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('config', 'crypt_md5', '$conf_crypt');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('config', 'register_activ', '$conf_activ');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('config', 'log_user', '$conf_log');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('config', 'mail_type', '$conf_mail');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('message', 'mail_subject', '$conf_mail_subject');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('message', 'mail_msg', 'Merci de vous �tre inscrit sur notre site, voici vos identifiants:\r\n\r\nPseudo: %pseudo%\r\nPassword: %password%\r\nEmail: %email%\r\n\r\nCordialement,\r\nLe Webmaster.');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('config', 'modif_timer', '10');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('config', 'register_timer', '10');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('style', 'error_color', 'red');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('message', 'pseudo_exist', 'Ce pseudo existe d�ja!');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('config', 'version', '2 beta');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('config', 'pseudo_min', '4');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('config', 'pseudo_max', '30');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('config', 'pass_min', '4');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('config', 'pass_max', '30');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('message', 'pseudo_minlen', 'Votre Pseudo doit comporter un minimum de %min% caract�res');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('message', 'pseudo_maxlen', 'Votre mot de pass ne doit pas d�passer %max% caract�res');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('message', 'pass_minlen', 'Votre mot de passe doit comporter un minimum de %min% caract�res');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('message', 'pass_maxlen', 'Votre mot de passe ne doit pas d�passer %max% caract�res');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('path', 'url_auth', '{$_SESSION['update_path']}');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('path', 'url_redir', '{$_SESSION['update_path']}index.php');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('path', 'url_create', '{$_SESSION['update_path']}user_create.php');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('path', 'url_login', '{$_SESSION['update_path']}user_login.php');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('path', 'url_logout', '{$_SESSION['update_path']}user_login.php?action=logout');",
  "INSERT INTO {$_SESSION['update_tableconf']} VALUES ('path', 'url_modif', '{$_SESSION['update_path']}user_update.php');");

  foreach($tab as $var)
  {
    $sql->query($var);
  }

  $sql->query("ALTER TABLE `auth_user` CHANGE `rang` `rang` ENUM( '1', '2', '3', '4' ) DEFAULT '1'");
  $res = $sql->query("SELECT pseudo FROM $sql_table WHERE pseudo='{$_SESSION['update_pseudo']}' LIMIT 1");

  if (mysql_num_rows($res) == 0)
  {
    $char = 'abcdefghijklmnopqrstuvwxyz0123456789';

    srand(time()); $id = '';
    for( $i=0; $i<20; $i++ )
    {
      $id .= substr($char,(rand()%(strlen($char))),1);
    }

    $password = ($conf_crypt == 1) ? md5($_SESSION['update_pass']) : $_SESSION['update_pass'];

    $register_date = date("d/m/Y H:i");
    $sql->query("INSERT INTO $sql_table (pseudo,password,email,rang,id,register_date,activ) VALUES('{$_SESSION['update_pseudo']}','$password','{$_SESSION['update_email']}','1','$id','$register_date','oui')");
  }
  else
  {
    $sql->query("UPDATE $sql_table SET pseudo='{$_SESSION['update_pseudo']}' WHERE pseudo='{$_SESSION['update_pseudo']}'");
  }

    //Cr�ation du fichier config.php

     if (file_exists('../config/config.php'))
	unlink('../config/config.php');

     fclose(fopen('../config/config.php', 'w'));

     $fp = fopen('../config/config.php', 'a');

     fseek($fp, 0);

     $sep = "\n";

     $t = "<?php \n \n";
     $t .= "include('bdd.class.php');\n";
     $t .= '$sql = new sql;'.$sep;
     $t .= '$sql->hote = "'.$sql->hote.'";'.$sep;
     $t .= '$sql->user = "'.$sql->user.'";'.$sep;
     $t .= '$sql->pass = "'.$sql->pass.'";'.$sep;
     $t .= '$sql->base = "'.$sql->base.'";'.$sep;
     $t .= '$sql_table = "'.$sql_table.'";'.$sep;
     $t .= '$sql_table_conf = "'.$_SESSION['update_tableconf'].'";'.$sep;
     $t .= "\n\n?>";

     fputs($fp, $t);

     fclose($fp);

  $sql->close();

  $_SESSION['confirm'] = 'ok';

  header('Location: update.php');
}

elseif( $_SESSION['confirm'] == 'ok')
{
  session_destroy();
  ?>

<html>

<head>
  <title>Update Shiva Auth 1.3 test - Confirmation</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="conteneur">

  <div id="entete">

    <h1>Confirmation</h1>

    Update succefully

  </div>

  <div id="centre">

    Le script <b>Shiva Authentification</b> (version 2 test) a correctement �t� updat�.<br /><br />
    Consultez la documentation mise � jour afin de prendre en compte les modifications apport�es.<br /><br />

    <a href="../index.php">S'authentifier</a>

    <br /><br />

    <span id="red">
	<img src="care.gif" alt="Attention !" align="left"><img src="care.gif" alt="Attention !" align="right">Pensez � effacez le dossier "install" du script, il ne vous est plus utile et permet � n'importe qui de reconfigurer le script.
   </span>
  </div>

  <div id="bas">

    Shiva Authentification version 1.3 (test) - License GPL

  </div>

</div>

</body>

</html>

<?php
}

else
{
?>

<html>

<head>
  <title>Update Shiva Auth 1.3 test - Update</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="conteneur">

  <div id="entete">

    <h1>Update</h1>

    Informations n�c�ssaires � la mise � jour

  </div>

  <div id="centre">

    <form action="update.php" method="post" name="form">

      <input type="hidden" name="update" value="1">

      <?php

      if (!empty($_SESSION['report']))
      {
	echo '<span id="red">' . $_SESSION['report'] . '</span><br /><br />';
	unset($_SESSION['report']);
      }

      ?>

      <b>Nom de la table de configuration:</b><br />
	<input type="text" name="update_tableconf" value="<?php echo isset($_SESSION['update_tableconf']) ? $_SESSION['update_tableconf'] : 'auth_conf'; ?>">
	<br /><br />
      <b>Url du script:</b><br />
	<input type="text" size="30" name="update_path" value="<?php echo isset($_SESSION['update_path']) ? $_SESSION['update_path'] : 'http://www.monsite.com/script/'; ?>">
        <br /><br />

	<?php
	$res = $sql->query("SELECT * FROM $sql_table ORDER BY pseudo ASC");

	if( mysql_num_rows($res) == 0)
	{
	  ?>

	  Cr�er un nouveau compte:<br />

	  Pseudo:<br /><input type="text" name="update_pseudo" value="<?php echo isset($_SESSION['update_pseudo']) ? $_SESSION['update_pseudo'] : ''; ?>"><br />
	  Pass:<br /><input type="text" name="update_pass" value="<?php echo isset($_SESSION['update_pass']) ? $_SESSION['update_pass'] : ''; ?>"><br />
	  Email:<br /><input type="text" name="update_email" value="<?php echo isset($_SESSION['update_email']) ? $_SESSION['update_email'] : ''; ?>"><br />

	  <?php
	}
	else
	{
	  echo '<b>Utilisateur � promouvoir au rang de Super-Admin:</b><br />';
	  echo '<select size="1" name="update_pseudo">';

	  while ($row = mysql_fetch_assoc($res))
	  {
	    echo '<option value="' .  $row['pseudo'] . '">' . $row['pseudo'] . '</option>';
	  }

	  echo '</select>';
	}
	?>

        <br /><br />

      <input type="submit" name="next" value="Update !">

    </form>

  </div>

  <div id="bas">

    Shiva Authentification version 1.3 (test) - License GPL

  </div>

</div>

</body>

</html>

<?php
$sql->close();
}

?>