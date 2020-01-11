<?php

session_start();

?>

<html>

<head>
  <title>Installation Shiva Auth 1.3 test - Step 2</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript">
  function ChangeStatut(formulaire)
  {
    if(formu.install_notable.checked == false)
    {
      formu.install_tablemembre.disabled = false;
      formu.install_tableconf.disabled = false;
    }
    if(formu.install_notable.checked == true)
    {
      formu.install_tablemembre.disabled = true;
      formu.install_tableconf.disabled = true;
    }
  }
  </script> 
</head>

<body>

<div id="conteneur">

  <div id="entete">

    <h1>Etape 2</h1>

    Création des tables MySQL

  </div>

  <div id="centre">

    <form action="step_register.php" method="post" name="formu">

      <input type="hidden" name="step" value="2">

      <?php

      if (!empty($_SESSION['report']))
      {
	echo '<span id="red">' . $_SESSION['report'] . '</span><br /><br />';
	unset($_SESSION['report']);
      }
		$Notable = isset($_SESSION['install_notable']) ? $_SESSION['install_notable'] : NULL;
      if ($Notable == 1)
	$che = ' checked';
      else
	$che = '';
      ?>

      <b>Table des membres:</b><br />
	<input type="text" name="install_tablemembre" value="<?php echo !empty($_SESSION['install_tablemembre']) ? $_SESSION['install_tablemembre'] : 'auth_user'; ?>"><br /><br />

      <b>Table des configurations:</b><br />
	<input type="text" name="install_tableconf" value="<?php echo !empty($_SESSION['install_tableconf']) ? $_SESSION['install_tableconf'] : 'auth_conf'; ?>"><br /><br />

      <input type="checkbox" name="install_notable" value="membres"<?php echo $che; ?>>
      Ne pas créer les table MySQL, elles existent déja<br /><br />

      <input type="button" name="precedent" value="&#60; Etape précédente" onclick="window.location='step1.php';">
      <input type="submit" name="next" value="Etape suivante &#62;">

    </form>

  </div>

  <div id="bas">

    Shiva Authentification version 1.3 (test) - License GPL

  </div>

</div>

</body>

</html>