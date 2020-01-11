<?php

session_start();

if (!isset($_POST['step']))
{
  header('Location: step1.php');

  exit();
}

if ($_POST['step'] == '1')
{
  $_SESSION['install_hote'] 	= $_POST['install_hote'];
  $_SESSION['install_user'] 	= $_POST['install_user'];
  $_SESSION['install_pass'] 	= $_POST['install_pass'];
  $_SESSION['install_base'] 	= $_POST['install_base'];
  $_SESSION['install_path'] 	= $_POST['install_path'];
  
  $install_hote = isset( $_POST['install_hote'] ) ? $_POST['install_hote'] : '';
  $install_user = isset( $_POST['install_user'] ) ? $_POST['install_user'] : '';
  $install_pass = isset( $_POST['install_pass'] ) ? $_POST['install_pass'] : '';
  $install_base = isset( $_POST['install_base'] ) ? $_POST['install_base'] : '';

  if (empty($install_hote) or empty($install_user) or empty($install_base))
  {
    $_SESSION['report'] = 'Remplissez tout les champs';

    header('Location: step1.php'); 
    exit();
  }

  if(!($connexion = @mysql_connect($install_hote, $install_user, $install_pass)))
  {
    $_SESSION['report'] = 'Connexion à la Base de donnée impossible';

    header('Location: step1.php');
    exit();
  }

  if(!($db = @mysql_select_db($install_base, $connexion)))
  {
    $_SESSION['report'] = 'Database introuvable';

    header('Location: step1.php');
    exit();
  }

  mysql_close($connexion);

  header('Location: step2.php');

  exit();
}

elseif ($_POST['step'] == '2')
{
  $_SESSION['install_tablemembre'] 	= $_POST['install_tablemembre'];
  $_SESSION['install_tableconf'] 	= $_POST['install_tableconf'];

  if (isset($_POST['install_notable']))
  {
    $_SESSION['install_notable'] 	= 1;
  }
  else
  {
    $_SESSION['install_notable'] 	= 0;

    $connexion = @mysql_connect($_SESSION['install_hote'], $_SESSION['install_user'], $_SESSION['install_pass']);
    $db = @mysql_select_db($_SESSION['install_base'], $connexion);

    if ($_SESSION['install_notable'] == '0')
    {
      @mysql_query("DROP TABLE IF EXISTS {$_SESSION['install_tablemembre']}");
      @mysql_query("DROP TABLE IF EXISTS {$_SESSION['install_tableconf']}");
    }

    $req1 = "CREATE TABLE {$_SESSION['install_tablemembre']} (	id VARCHAR(20) NOT NULL,pseudo VARCHAR(30) NOT NULL,password VARCHAR(40) NOT NULL,
										email VARCHAR(40) NOT NULL,rang ENUM('1','2','3','4') DEFAULT 1,register_date VARCHAR(20),
										activ VARCHAR(10) DEFAULT 'non',UNIQUE KEY `id` (`id`))";

    $req2 = "CREATE TABLE {$_SESSION['install_tableconf']} (`type` varchar(50) NOT NULL default '',`nom` varchar(50) NOT NULL default '',`valeur` text NOT NULL)";

    if (!empty($_SESSION['install_tablemembre']))
      mysql_query($req1);
    if (!empty($_SESSION['install_tableconf']))
      mysql_query($req2);

    mysql_close($connexion);
  }

  header('Location: step3.php');

  exit();
}

elseif ($_POST['step'] == '3')
{
  $_SESSION['install_crypt'] 	= $_POST['install_crypt'];
  $_SESSION['install_activ'] 	= $_POST['install_activ'];
  $_SESSION['install_logs'] 	= $_POST['install_logs'];
  $_SESSION['install_email'] 	= $_POST['install_email'];


  $connexion = @mysql_connect($_SESSION['install_hote'], $_SESSION['install_user'], $_SESSION['install_pass']);
  $db = @mysql_select_db($_SESSION['install_base'], $connexion);

  $tab = array(
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('message', 'no_champs', 'Remplissez tout les champs !');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('message', 'no_pass', 'Pseudo ou password incorrect !');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('message', 'compte_desactive', 'Votre compte est désactivé !');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('message', 'compte_blacklist', 'Votre compte est placé sur la BlackList !');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('message', 'no_passold', 'Votre mot de passe ne doit pas dépasser %max% caractères');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('message', 'no_passconf', 'Confirmation de votre mot de passe incorrecte !');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('message', 'mail_sent', 'Un e-mail vous a été envoyé avec vos identifiants de connexion');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('message', 'mail_sentproto', 'Un e-mail vous a été envoyé avec vos identifiants de connexion (avec <a href=\"http://samuel.kabak.free.fr\" target=\"blank\">Protomail</a>)');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('message', 'register_conf', 'Votre inscription s\'est effectuée avec succès !');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('message', 'modif_conf', 'La modification de votre profil s\'est effectuée avec succès !');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('style', 'crypt_color', '#A3A3A3');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('message', 'crypt_avert', 'Attention, le password est crypté et ne peut pas être récupéré !');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('config', 'crypt_md5', '" . $_SESSION['install_crypt'] . "');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('config', 'register_activ', '" . $_SESSION['install_activ'] . "');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('config', 'log_user', '" . $_SESSION['install_logs'] . "');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('config', 'mail_type', '" . $_SESSION['install_email'] . "');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('message', 'mail_subject', 'Email de confirmation');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('message', 'mail_msg', 'Merci de vous être inscrit sur notre site, voici vos identifiants:\r\n\r\nPseudo: %pseudo%\r\nPassword: %password%\r\nEmail: %email%\r\n\r\nCordialement,\r\nLe Webmaster.');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('config', 'modif_timer', '10');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('config', 'register_timer', '10');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('style', 'error_color', 'red');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('message', 'pseudo_exist', 'Ce pseudo existe déja!');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('config', 'version', '2 beta');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('config', 'pseudo_min', '4');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('config', 'pseudo_max', '30');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('config', 'pass_min', '4');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('config', 'pass_max', '30');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('message', 'pseudo_minlen', 'Votre Pseudo doit comporter un minimum de %min% caractères');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('message', 'pseudo_maxlen', 'Votre mot de pass ne doit pas dépasser %max% caractères');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('message', 'pass_minlen', 'Votre mot de passe doit comporter un minimum de %min% caractères');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('message', 'pass_maxlen', 'Votre mot de passe ne doit pas dépasser %max% caractères');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('path', 'url_auth', '{$_SESSION['install_path']}');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('path', 'url_redir', '{$_SESSION['install_path']}index.php');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('path', 'url_create', '{$_SESSION['install_path']}user_create.php');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('path', 'url_login', '{$_SESSION['install_path']}user_login.php');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('path', 'url_logout', '{$_SESSION['install_path']}user_login.php?action=logout');",
  "INSERT INTO {$_SESSION['install_tableconf']} VALUES ('path', 'url_modif', '{$_SESSION['install_path']}user_update.php');");

  foreach($tab as $var)
  {
    mysql_query($var);
  }

  mysql_close($connexion);

  header('Location: step4.php');

  exit();
}

elseif ($_POST['step'] == '4')
{
  $_SESSION['install_userpseudo']	= $_POST['install_userpseudo'];
  $_SESSION['install_userpass'] 	= $_POST['install_userpass'];
  $_SESSION['install_usermail'] 	= $_POST['install_usermail'];

  $install_userpseudo	= $_SESSION['install_userpseudo'];
  $install_userpass 	= $_SESSION['install_userpass'];
  $install_usermail 	= $_SESSION['install_usermail'];

  if (empty($_SESSION['install_userpseudo']) || empty($_SESSION['install_userpass']))
  {
    $_SESSION['report'] = 'Remplissez tout les champs';

    header('Location: step4.php'); 
    exit();
  }

  $char = "abcdefghijklmnopqrstuvwxyz0123456789";
  $id = '';

  srand(time());
  for ($i = 0; $i < 20; $i++)
    $id .= substr ( $char, ( rand ()% ( strlen ( $char ) ) ) , 1 );

  if ($_SESSION['install_crypt'] == '1')
    $install_userpass = md5($install_userpass);

  $register_date = date("d/m/Y H:i");

  $connexion = @mysql_connect($_SESSION['install_hote'], $_SESSION['install_user'], $_SESSION['install_pass']);
  $db = @mysql_select_db($_SESSION['install_base'], $connexion);

  $query = "INSERT INTO {$_SESSION['install_tablemembre']} (id,pseudo,password,email,rang,register_date,activ) VALUES('$id','$install_userpseudo','$install_userpass','$install_usermail','4','$register_date','oui')";
  mysql_query($query);

    //Création du fichier config.php

     if (file_exists('../config/config.php'))
	unlink('../config/config.php');

     fclose(fopen('../config/config.php', 'w'));

     $fp = fopen('../config/config.php', 'a');

     fseek($fp, 0);

     $sep = "\n";

     $t = "<?php \n \n";
     $t .= "include('bdd.class.php');\n";
     $t .= '$sql = new sql;'.$sep;
     $t .= '$sql->hote = "'.$_SESSION['install_hote'].'";'.$sep;
     $t .= '$sql->user = "'.$_SESSION['install_user'].'";'.$sep;
     $t .= '$sql->pass = "'.$_SESSION['install_pass'].'";'.$sep;
     $t .= '$sql->base = "'.$_SESSION['install_base'].'";'.$sep;
     $t .= '$sql_table = "'.$_SESSION['install_tablemembre'].'";'.$sep;
     $t .= '$sql_table_conf = "'.$_SESSION['install_tableconf'].'";'.$sep;
     $t .= "\n\n?>";

     fputs($fp, $t);

     fclose($fp);  

  header('Location: step5.php');

  exit();
}
?>