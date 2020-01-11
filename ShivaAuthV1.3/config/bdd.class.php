<?php

class sql
{
  var $hote = 'localhost';
  var $user = 'root';
  var $pass = '';
  var $base = 'test';

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

    $in[$id] = mysql_connect($this->hote, $this->user, $this->pass) or die (mysql_error());
  }


  function close( $id='defaut' )
  {
    global $in;

    mysql_close($in[$id]);
  }

  function query( $req, $base='', $id='defaut' )
  {
    global $in;

    $base = empty( $base ) ? $this->base : $base;

    $db = mysql_select_db($base, $in[$id]) or die (mysql_error());

    $res = mysql_query( $req ) or die (mysql_error());

    return $res;
  }
}

$sql = new sql;

?>