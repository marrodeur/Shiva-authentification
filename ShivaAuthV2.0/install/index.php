<?php

session_start();

?>

<html>

<head>
  <title>Installation Shiva Auth 1.3 test - Step 0</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="conteneur">

  <div id="entete">

    <h1>Etape 0</h1>

    Action à effectuer

  </div>

  <div id="centre">

	Bienvenue dans la partie "installation" du script <b>Shiva Auth</b> (version 1.3 test);<br /><br />

	Que souhaitez-vous faire ?<br /><br />

      <input type="button" name="precedent" value="Mettre à jour le script" onclick="document.location='update.php';"> &nbsp; 
      <input type="submit" name="next" value="Installer le script" onclick="document.location='step1.php';">

  </div>

  <div id="bas">

    Shiva Authentification version 1.3 (test) - License GPL

  </div>

</div>

</body>

</html>