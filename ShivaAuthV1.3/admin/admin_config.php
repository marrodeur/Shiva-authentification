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

if( empty( $_GET['action'] ) and empty( $_POST['action'] ) )
{

  //En-tête de la page

  define ("SHIVA", "true");

  include('header.php');

  ?>

	<br>Configuration du Script :</font></b></p>

	<form style="width: 650px; text-align: left;" name="configure" action="admin_config.php" method="post">

	<input type="hidden" name="action" value="configure">

  <?php

  $sql->open();


  $res = $sql->query("SELECT * FROM $sql_table_conf ORDER BY type,nom ASC");

  while( $row = mysql_fetch_assoc( $res ) )
  {
    $config[$row['type']][$row['nom']] = $row['valeur'];
  }

  ?>

  <p style="font-family: Verdana; font-size: 10pt;">

  <div class="title"><b>Messages d'erreurs des formulaires:</b></div><br /><br />

    <p style="padding-left: 20px;">

	<div class="nom">Champs vides: </div>
	<div class="valeur"><input type="text" class="form" value="<?php echo stripslashes($config['message']['no_champs']); ?>" name="no_champs"></div><br /><br />

	<div class="nom">Password incorrect: </div>
	<div class="valeur"><input type="text" class="form" value="<?php echo stripslashes($config['message']['no_pass']); ?>" name="no_pass"></div><br /><br />

	<div class="nom">Ancien password incorrect: </div>
	<div class="valeur"><input type="text" class="form" value="<?php echo stripslashes($config['message']['no_passold']); ?>" name="no_passold"></div><br /><br />

    </p><br />

  <div class="title"><b>Paramètres d'inscription:</b></div><br /><br />

    <p style="padding-left: 20px;">

	<div class="nom">Pseudo trop court: </div>
	<div class="valeur"><input type="text" class="form" value="<?php echo stripslashes($config['message']['pseudo_minlen']); ?>" name="pseudo_minlen"></div><br /><br />

	<div class="nom">Pseudo trop long: </div>
	<div class="valeur"><input type="text" class="form" value="<?php echo stripslashes($config['message']['pseudo_maxlen']); ?>" name="pseudo_maxlen"></div><br /><br />

	<div class="nom">Password trop court: </div>
	<div class="valeur"><input type="text" class="form" value="<?php echo stripslashes($config['message']['pass_minlen']); ?>" name="pass_minlen"></div><br /><br />

	<div class="nom">Password trop long: </div>
	<div class="valeur"><input type="text" class="form" value="<?php echo stripslashes($config['message']['pass_maxlen']); ?>" name="pass_maxlen"></div><br /><br />

	<div class="nom" style="padding-top: 2px;">Taille minimum du pseudo *:</div>
	<div class="valeur">
	  <input type="text" size="2" name="pseudo_min" value="<?php echo $config['config']['pseudo_min']; ?>"> caractères
	</div><br />

	<div class="nom" style="padding-top: 2px;">Taille maximum du pseudo *:</div>
	<div class="valeur">
	  <input type="text" size="2" name="pseudo_max" value="<?php echo $config['config']['pseudo_max']; ?>"> caractères
	</div><br /><br />

	<div class="nom" style="padding-top: 2px;">Taille minimum du password *:</div>
	<div class="valeur">
	  <input type="text" size="2" name="pass_min" value="<?php echo $config['config']['pass_min']; ?>"> caractères
	</div><br />

	<div class="nom" style="padding-top: 2px;">Taille maximum du password *:</div>
	<div class="valeur">
	  <input type="text" size="2" name="pass_max" value="<?php echo $config['config']['pass_max']; ?>"> caractères
	</div><br /><br />

	<div class="nom" style="padding-top: 2px;">* mettez "0" pour "aucun":</div><br /><br />

    </p><br />

  <div class="title"><b>Messages d'erreurs d'activation:</b></div><br /><br />

    <p style="padding-left: 20px;">

	<div class="nom">Compte désactivé: </div>
	<div class="valeur"><input type="text" class="form" value="<?php echo stripslashes($config['message']['compte_desactive']); ?>" name="compte_desactive"></div><br /><br />

	<div class="nom">Compte sur Blacklist: </div>
	<div class="valeur"><input type="text" class="form" value="<?php echo stripslashes($config['message']['compte_blacklist']); ?>" name="compte_blacklist"></div><br /><br />

    </p><br />

  <div class="title"><b>Messages de confirmation:</b></div><br /><br />

    <p style="padding-left: 20px;">

	<div class="nom">Confirmation du password incorrect: </div>
	<div class="valeur"><input type="text" class="form" value="<?php echo stripslashes($config['message']['no_passconf']); ?>" name="no_passconf"></div><br /><br />

	<div class="nom">Confirmation d'inscription: </div>
	<div class="valeur"><input type="text" class="form" value="<?php echo stripslashes($config['message']['register_conf']); ?>" name="register_conf"></div><br /><br />

	<div class="nom">Confirmation de modification: </div>
	<div class="valeur"><input type="text" class="form" value="<?php echo stripslashes($config['message']['modif_conf']); ?>" name="modif_conf"></div><br /><br />

    </p><br />

  <div class="title"><b>Messages des mails:</b></div><br /><br />

    <p style="padding-left: 20px;">

	<div class="nom">Mail envoyé: </div>
	<div class="valeur"><textarea style="width: 100%; height: 50px;" name="mail_sent"><?php echo stripslashes($config['message']['mail_sent']); ?></textarea></div><br /><br />

	<div class="nom">Mail envoyé (protomail): </div>
	<div class="valeur"><textarea style="width: 100%; height: 50px;" name="mail_sentproto"><?php echo stripslashes($config['message']['mail_sentproto']); ?></textarea></div><br /><br />

	<div class="nom">Sujet du mail: </div>
	<div class="valeur"><input type="text" class="form" value="<?php echo stripslashes($config['message']['mail_subject']); ?>" style="width: 100%" name="mail_subject"></div><br /><br />

	<div class="nom">Message du mail: </div>
	<div class="valeur"><textarea rows="6" style="width: 100%; height: 100px;" name="mail_msg"><?php echo stripslashes($config['message']['mail_msg']); ?></textarea></div>

    </p><br />

  <div class="title"><b>Messages divers:</b></div><br /><br />

    <p style="padding-left: 20px;">

	<div class="nom">Avertissement cryptage password: </div>
	<div class="valeur"><input type="text" class="form" value="<?php echo stripslashes($config['message']['crypt_avert']); ?>" name="crypt_avert"></div><br /><br />

    </p><br /><br />

  <div class="title"><b>Styles:</b></div><br /><br />

    <p style="padding-left: 20px;">

	<div class="nom">Couleur des messages d'erreur: </div>
	<div class="valeur"><input type="text" class="form" value="<?php echo stripslashes($config['style']['error_color']); ?>" name="error_color"></div><br /><br />

	<div class="nom">Couleur de l'avertissement de cryptage: </div>
	<div class="valeur"><input type="text" class="form" value="<?php echo stripslashes($config['style']['crypt_color']); ?>" name="crypt_color"></div><br /><br />

    </p><br />

  <div class="title"><b>Paramètres de sécurité:</b></div><br /><br />

    <p style="padding-left: 20px;">

	<div class="nom">Cryptage du password (md5): </div>
	<div class="valeur">
	  <input type="radio" name="crypt_md5" value="1"<?php if( $config['config']['crypt_md5'] == '1') echo ' checked'; ?>>Oui &nbsp; 
	  <input type="radio" name="crypt_md5" value="0"<?php if( $config['config']['crypt_md5'] == '0') echo ' checked'; ?>>Non
	</div>
	<br /><br />

	<div class="nom">Log des connexions: </div>
	<div class="valeur">
	  <input type="radio" name="log_user" value="1"<?php if( $config['config']['log_user'] == '1') echo ' checked'; ?>>Activé &nbsp; 
	  <input type="radio" name="log_user" value="0"<?php if( $config['config']['log_user'] == '0') echo ' checked'; ?>>Désactivé
	</div>
	<br /><br />

	<div class="nom">Activation du compte par l'admin: </div>
	<div class="valeur">
	  <input type="radio" name="register_activ" value="1"<?php if( $config['config']['register_activ'] == '1') echo ' checked'; ?>>Oui &nbsp; 
	  <input type="radio" name="register_activ" value="0"<?php if( $config['config']['register_activ'] == '0') echo ' checked'; ?>>Non
	</div>
	<br /><br />

    </p><br />

  <div class="title"><b>Paramètres de confirmation:</b></div><br /><br />

    <p style="padding-left: 20px;">

	<div class="nom">Mail de confirmation: </div>
	<div class="valeur">
	  <input type="radio" name="mail_type" value="0"<?php if( $config['config']['mail_type'] == '0') echo ' checked'; ?>>Non &nbsp; 
	  <input type="radio" name="mail_type" value="1"<?php if( $config['config']['mail_type'] == '1') echo ' checked'; ?>>Oui &nbsp; 
	  <input type="radio" name="mail_type" value="2"<?php if( $config['config']['mail_type'] == '2') echo ' checked'; ?>>Protomail &nbsp; 
	</div>
	<br /><br />

	<div class="nom" style="padding-top: 2px;">Temps avant redirection (inscription):</div>
	<div class="valeur">
	  <input style="vertical-align: middle;" type="text" size="2" name="register_timer" value="<?php echo $config['config']['register_timer']; ?>"> secondes
	</div><br /><br />

	<div class="nom" style="padding-top: 2px;">Temps avant redirection (modification):</div>
	<div class="valeur">
	  <input type="text" size="2" name="modif_timer" value="<?php echo $config['config']['modif_timer']; ?>"> secondes
	</div>

    </p><br />

  </p>

  <br />


  <center><input type="submit" name="valider" value="Effectuer les mises à jour" style="width: auto;"></center>
  </form>

  <?php

  $sql->close();


  exit();
}

elseif( !empty( $_POST['action'] ) and $_POST['action'] == 'configure' )
{
  //Vérification préalables

  $post = array('no_champs','no_pass','compte_desactive','compte_blacklist','no_passold','no_passconf','mail_sent','mail_sentproto','register_conf','modif_conf','crypt_color','crypt_avert','crypt_md5','register_activ','log_user','mail_type','mail_subject','mail_msg','modif_timer','register_timer','error_color','pseudo_min','pseudo_max','pass_min','pass_max','pseudo_minlen','pseudo_maxlen','pass_minlen','pass_maxlen');

  foreach( $post as $var )
  {
    if( $_POST[$var] == '' )
    {
      report('Remplissez tout les champs');

      header('Location: admin_config.php');

      exit();
    }
  }

  $sql->open();

  foreach( $post as $var )
  {
    if( $sql->query("UPDATE $sql_table_conf SET valeur='{$_POST[$var]}' WHERE nom='$var'") == false )
    {
      report('Erreur lors de l\'update de: ' . $var );
    }
  }

  $sql->close();

  if( empty( $_SESSION['report'] ) )
  {
    report('Update effectué avec succès !');
  }

  header('Location: admin_config.php');

  exit();
}


else
{
  header( 'Location: admin_user.php' );

  exit();
}

?>