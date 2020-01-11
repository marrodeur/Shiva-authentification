<?php /* V�rification de l'installation ==> */ if ( !file_exists('config/config.php') ) { header("Location: install/index.php"); exit; }

//---------------------------------------------------------------
// 
// Page: index.php
// Autheur: Pascal Viney
// Fonction: Affiche des exemples d'utilisation des fonctions
// Cette page contient quelques exemples d'utilisation du script
//
//---------------------------------------------------------------

//-------------------------------------------------------------------------------
// On d�clare l'ouverture de la session (� mettre toujours en haut de page):
// Ce code de 2 lignes est � placer sur chaque page o� vous utiliserez le script
//-------------------------------------------------------------------------------

include('user_verif.php');


//--------------------------------------------------------------------------------
// On restreint l'acc�s � la page aux membres de rang sup�rieur � 1 (c'est � dire
// tout les membres, puisque 1 est le plus bas rang, 0 d�signe une personne non
// logu�e), donc si la personne n'est pas loggu�e, elle est redirig�e vers la page
// sp�cifi�e en deuxi�me position entre les parenth�ses (dans le cas ci-dessous,
// c'est "login.php?action=login" qui redirige vers la page de connexion, vous
// pouvez tout � fait rediriger vers "erreur.htm" par exemple).
//--------------------------------------------------------------------------------

user_verif("1", "user_login.php");

//--------------------------------------------------------------------------------
//on affiche le nombre de membres total loggu�s, avec la fonction: stats('nb', '123');
//--------------------------------------------------------------------------------
?>

<center style="font-family: Verdana; font-size: 10pt;">

<h3 style="margin-bottom: 0px;">Shiva authentification</h3>(version <?php echo $cfg['config']['version']; ?>)

<br /><br />

<font face="Arial" size="2">

Vous �tes connect� sous: <a href="mailto: <?php user('email'); ?>"><?php user('pseudo'); ?></a> en tant que <b><?php user('rang'); ?></b>

<br>
<br>

Il y a <?php  stats('nb', '1234');  ?> membres sur le site.

<br>

</font>


<?php
//----------------------------------------------------------------------------------
//on affiche ensuite la liste de tout les membres, avec la fonction: stats('ls', '123');
//----------------------------------------------------------------------------------
?>

<font face="Arial" size="2">

En voici la liste:
<br>
<br>

<?php stats('ls', 1234);  ?>

</font>

<br>

<?php
//------------------------------------------------------------------------
//on va maintenant utiliser diff�rentes variantes de la fonction: stats();
//------------------------------------------------------------------------
?>


<font face="Arial" size="2">

Il y a <?php  stats('nb', '3');  ?> administrateurs et <?php  stats('nb', '2');  ?> mod�rateurs sur le site.
<br>
<br>

Le <b>Super-Utilisateur</b>:
<br />
<font color="red">
<b><?php stats('ls', '4');  ?></b>
</font>

<br />

Les <b>administrateurs</b>:
<br>
<font color="red">
<?php stats('ls', '3');  ?>
</font>

<br>

Les <b>mod�rateurs</b>:
<br>
<font color="blue">
<?php stats('ls', '2');  ?>

<br>
<br>

<?php $html='<a href="admin/index.php">Administration</a>'; affiche($html, '34'); ?><br>
<?php $html='<a href="user_login.php?action=logout">D�connexion</a>'; affiche($html, '1234'); ?><br>
<?php $html='<a href="user_update.php">Editer profil</a>'; affiche($html, '1234'); ?>


</font>

</center>



