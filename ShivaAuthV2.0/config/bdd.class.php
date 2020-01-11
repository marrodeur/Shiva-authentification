<?php

class sql
{
  var $hote = 'localhost';
  var $user = 'doc-tel';
  var $pass = '6200jhad';
  var $base = 'shiva';

  function sql( $tab='' )
  {
    $this->hote = isset( $tab['hote'] ) ? $tab['hote'] : $this->hote;
    $this->user = isset( $tab['user'] ) ? $tab['user'] : $this->user;
    $this->pass = isset( $tab['pass'] ) ? $tab['pass'] : $this->pass;
    $this->base = isset( $tab['base'] ) ? $tab['base'] : $this->base;
  }

  function open( $id='defaut' )
  {
    global $in, $sql;
    $in[$id] = mysqli_connect($this->hote, $this->user, $this->pass, $this->base) or die ();
	if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
  }


  function close( $id='defaut' )
  {
    global $in;

    mysqli_close($in[$id]);
  }

  function query( $req, $base='', $id='defaut' )
  {
    global $in;

    $base = empty( $base ) ? $this->base : $base;

    $db = mysqli_select_db($in[$id], $base) or die (mysqli_error($in[$id]));

    $res = mysqli_query($in[$id], $req ) or die (mysqli_error($in[$id]));

    return $res;
  }
}

$sql = new sql;

?>