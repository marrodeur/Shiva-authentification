<?php

//--------------------------------
// Crée/Ajoute un report d'erreur
//--------------------------------

function report( $arg, $end = '<br />', $name = 'report', $color = 'defaut' )
{
  global $cfg;

  $color = $cfg['style']['error_color'];

  if ( !isset( $_SESSION[$name] ) )
  {
    $_SESSION[$name] = '';
  }

  $_SESSION[$name] .= '<font style="color: ' . $color . '">' . $arg . '</font><br/>' . $end;
}


//----------------------------
// Affiche un report d'erreur
//----------------------------

function report_disp( $name = 'report' )
{
  echo ( isset( $_SESSION[$name] ) and !empty( $_SESSION[$name] ) ) ? $_SESSION[$name] : '';

  $_SESSION[$name] = '';
}


//-----------------------------
// Restreint l'acces à la page
//-----------------------------

function user_verif( $type, $loc = URL_LOGIN )
{
  if( !AUTH_ID or ( $type == '1' and AUTH_RANG < '1' ) or ( $type == '2' and AUTH_RANG < '2' ) or ( $type == '3' and AUTH_RANG < '3' ) or ( $type == '4' and AUTH_RANG != '4' ) )
  {
    exit( header("Location: $loc") );
  }
}


//--------------------------------------
// Affiche les infos du membre connecté
//--------------------------------------

function user( $var )
{
  $tab = array( 'pseudo' => AUTH_PSEUDO, 'email' => AUTH_EMAIL, 'rang' => AUTH_RANG, 'regdate' => AUTH_REGDATE );

  $t = array( '0' => 'anonyme', '1'=>'utilisateur', '2'=>'modérateur', '3'=>'administrateur', '4'=>'Super-Utilisateur' );

  if( AUTH_ID and isset( $tab[$var] ) )
  {
    if ( $var == 'rang' )
    {
      echo $t[AUTH_RANG];
    }

    else
    {
      echo $tab[$var];
    }
  }

  else
  {
    if ( $var == 'rang' )
    {
      echo $t[0];
    }
  }
}


//--------------------------------------
// Affiche les statistiques des membres
//--------------------------------------

function stats($do,$for)
{
  global $sql_table, $sql;

  $sql->open();

  if ( ereg("1|2|3|4", $for) )
  {
    $res = array();

    for( $n=1; $n<=4; $n++ )
    {
      if( ereg( $n, $for ) )
      {
	$res[] = $n;
      }
    }

    $in = implode( "','", $res );


    $result = $sql->query("SELECT * FROM $sql_table WHERE rang IN ('$in') ORDER By pseudo,rang");


    if ( $do == 'nb' )
    {
      echo mysql_num_rows($result);   
    }

    elseif( $do == 'ls' )
    {
      if ( mysql_num_rows($result) == 0 )
      {
	echo '<i>Aucun</i>';
      }

      else
      {
	while ($row = mysql_fetch_assoc($result))
	{
	  echo $row['pseudo'] . '<br>';
	}
      }
    }
  }

  $sql->close();
}

//---------------------------------------
// Affiche un lien pour le rang spécifié
//---------------------------------------

function affiche( $html, $for )
{
  if ( ( ereg("1", $for) and AUTH_RANG == '1' ) or ( ereg("2", $for) and AUTH_RANG == '2' ) or ( ereg("3", $for) and AUTH_RANG == '3' ) or ( ereg("4", $for) and AUTH_RANG == '4' ) )
  {
    echo $html;
  }
}


?>