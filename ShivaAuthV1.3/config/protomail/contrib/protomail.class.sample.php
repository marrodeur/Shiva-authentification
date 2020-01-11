<?php

include('protomail.class.php');

/* Création de l'instance */
$FreeMail = new Protomail();

/* IP ou DNS */
// $FreeMail->UseDns = true;

/* Authentification Free */
$FreeMail->Username = 'LoginFree';
$FreeMail->Password = 'PassFree';

/* Paramétrages mail */
/* Expéditeur du mail */
$FreeMail->ProtomailFrom('myaccount@free.fr', 'My Name');  // Nom faculitatif

/* Destinataire(s) du mail (To) */
$FreeMail->ProtomailAddAddress('pseudo@domain.com', 'This Name');  // Nom faculitatif       // pseudo@domain.com
$FreeMail->ProtomailAddAddress('anyone@domain.net'); // Ajoute d'un second destinataire (To)

/* Destinataire(s) du mail (Cc) */
// $FreeMail->ProtomailAddCc('pseudo@domain.com', 'This Name');  // Nom faculitatif
// $FreeMail->ProtomailAddCc('anyone@domain.net'); // Ajoute d'un second destinataire (Cc)

/* Destinataire(s) du mail (Bcc) */
// $FreeMail->ProtomailAddBcc('pseudo@domain.com', 'This Name');  // Nom faculitatif
// $FreeMail->ProtomailAddBcc('anyone@domain.net'); // Ajoute d'un second destinataire (Bcc)

/* Sujet du mail */
$FreeMail->Subject = 'Mon sujet de mail';
/* Corps du mail */
$FreeMail->Body = 'Mon body de mail !';

/* Envoi du mail */
if($FreeMail->ProtomailSend())
	echo 'E-mail envoyé';
else
	echo 'E-mail non envoyé : '. $FreeMail->Error;

?>
