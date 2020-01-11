<?php

session_start();

?>

<html>

<head>
  <title>Installation Shiva Auth 1.3 test - Step 1</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="conteneur">

  <div id="entete">

    <h1>Etape 1</h1>

    Configuration de la base de donnée MySQL

  </div>

  <div id="centre">

    <form action="step_register.php" method="post" name="form">

      <input type="hidden" name="step" value="1">

      <?php

      if (!empty($_SESSION['report']))
      {
	echo '<span id="red">' . $_SESSION['report'] . '</span><br /><br />';
	unset($_SESSION['report']);
      }

      ?>

      <b>Serveur/Hote:</b><br />
	<input type="text" name="install_hote" value="<?php echo isset($_SESSION['install_hote']) ? $_SESSION['install_hote'] : ''; ?>"><br /><br />
      <b>Nom d'utilisateur:</b><br />
	<input type="text" name="install_user" value="<?php echo isset($_SESSION['install_user']) ? $_SESSION['install_user'] : ''; ?>"><br /><br />
      <b>Password:</b><br />
	<input type="text" name="install_pass" value="<?php echo isset($_SESSION['install_pass']) ? $_SESSION['install_pass'] : ''; ?>"><br /><br />
      <b>Base de donnée:</b><br />
	<input type="text" name="install_base" value="<?php echo isset($_SESSION['install_base']) ? $_SESSION['install_base'] : ''; ?>"><br /><br />

      <b>Url du script:</b><br />
	<input type="text" size="30" name="install_path" value="<?php echo isset($_SESSION['install_path']) ? $_SESSION['install_path'] : 'http://www.monsite.com/script/'; ?>">
        <br /><br />


      <input type="button" name="precedent" value="&#60; Etape précédente" onclick="document.location(step1.php);" disabled>
      <input type="submit" name="next" value="Etape suivante &#62;">

    </form>

  </div>

  <div id="bas">

    Shiva Authentification version 1.3 (test) - License GPL

  </div>

</div>

</body>

</html>