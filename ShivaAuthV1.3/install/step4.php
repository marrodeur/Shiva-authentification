<?php

session_start();

?>

<html>

<head>
  <title>Installation Shiva Auth 1.3 test - Step 4</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="conteneur">

  <div id="entete">

    <h1>Etape 4</h1>

    Création du compte Super-Administrateur

  </div>

  <div id="centre">

    <form action="step_register.php" method="post" name="form">

      <input type="hidden" name="step" value="4">

      <?php

      if (!empty($_SESSION['report']))
      {
	echo '<span id="red">' . $_SESSION['report'] . '</span><br /><br />';
	unset($_SESSION['report']);
      }

      ?>

      <b>Pseudo:</b><br />
	<input type="text" name="install_userpseudo" value="<?php echo isset($_SESSION['install_userpseudo']) ? $_SESSION['install_userpseudo'] : ''; ?>"><br /><br />
      <b>Password:</b><br />
	<input type="text" name="install_userpass" value="<?php echo isset($_SESSION['install_userpass']) ? $_SESSION['install_userpass'] : ''; ?>"><br /><br />
      <b>E-mail:</b><br />
	<input type="text" name="install_usermail" value="<?php echo isset($_SESSION['install_usermail']) ? $_SESSION['install_usermail'] : ''; ?>"><br /><br />

      <input type="button" name="precedent" value="&#60; Etape précédente" onclick="document.location='step3.php';">
      <input type="submit" name="next" value="Finir l'installation !">

    </form>

  </div>

  <div id="bas">

    Shiva Authentification version 1.3 (test) - License GPL

  </div>

</div>

</body>

</html>