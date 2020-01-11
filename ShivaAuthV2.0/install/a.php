<?php

echo $_SERVER['HTTP_HOST'];

echo str_replace("install/a.php", "", $_SERVER['PHP_SELF']);

?>