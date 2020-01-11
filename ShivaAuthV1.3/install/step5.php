<?php

session_start();

session_destroy();

?>

<html>

<head>
  <title>Installation Shiva Auth 1.3 test - Confirmation</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="conteneur">

  <div id="entete">

    <h1>Confirmation</h1>

    Installation complète

  </div>

  <div id="centre">

    Le script <b>Shiva Authentification</b> (version 2 test) a correctement été installé sur votre serveur.<br /><br />
    Pour obtenir plus d'informations sur l'utilisation du script, consultez la documentation fournie avec le script.<br /><br />

    <a href="../index.php">S'authentifier</a>

    <br /><br />

    <span id="red">
	<img src="care.gif" alt="Attention !" align="left"><img src="care.gif" alt="Attention !" align="right">Pensez à effacez le dossier "install" du script, il ne vous est plus utile et permet à n'importe qui de reconfigurer le script.
   </span>

  </div>

  <div id="bas">

    Shiva Authentification version 1.3 (test) - License GPL

  </div>

</div>

</body>

</html>