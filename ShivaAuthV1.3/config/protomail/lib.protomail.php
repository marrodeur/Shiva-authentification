<?php
$FileDef = '__LIB_PROTOMAIL__';
if (defined($FileDef)) return; else define($FileDef, 1);

/*
  Protomail V4.2
  Licence GPL
  Auteur: Samuel KABAK, Codeas (http://www.codeas.net/)
  Utilisation:
    Introduire ici votre login et votre mot de passe free dans $user_name et $user_passwd
    Ajouter dans vos scripts:
      include("lib.protomail.php");
    et utiliser la fonction protomail exactement de la même manière que la fonction mail
*/

$user_name=$conf_email_user;
$user_passwd=$conf_email_pass;

/* les ip's du serveur imp (nslookup imp.free.fr) */
$i=0;

$server_ips[$i++] = '212.27.42.5';
$server_ips[$i++] = '212.27.42.1';
$server_ips[$i++] = '212.27.42.3';
$server_ips[$i++] = '212.27.42.4';
$server_ips[$i++] = '212.27.42.6';
$server_ips[$i++] = '212.27.42.2';

/* choisir un serveur initial par randum */

srand ((double) microtime() * 10000000);
$server_ip_index =  array_rand ($server_ips);


/* ou choisir un serveur initial fixe */
/* $server_ip_index = 1; */

/* choisissez le nombre de tentatives de connexion */
$nb_retry = 36;

/* ou choisir un serveur */
//$server_ip = $server_ips[6];

/* l'utilisation de imp.free.fr est possible mais ne semble pas fonctionner */

$server_dns = 'imp.free.fr';

$use_dns = false;

function sendhttp($msg,$taille_lue = 2048) {
  global $server_ip_index, $server_ips, $nb_retry, $server_dns, $use_dns ;

  $response = "";

  if (!$use_dns) {
    $server_ips_number = sizeof($server_ips);
    $server_ip =  $server_ips[$server_ip_index];

    for ($k=0;$k<$server_ips_number;$k++) {
      // 36 tentatives par sereur
      for ($j=0; $j<$nb_retry; $j++) {
        $fp = fsockopen($server_ip, 80, $errno, $errstr,30);
        if ($fp)
          break;
      }
      if ($fp)
        break;
      $server_ip_index = ($server_ip_index +1) % $server_ips_number;
    }
  } else
    $fp = fsockopen($server_dns, 80, $errno, $errstr,30);

  if(!$fp) {
//    print("Connexion impossible : $errstr ($errno)<br>"); /* pour le debug */
    return null;
  } else {
    fputs($fp,$msg);

    $response.= fread($fp,$taille_lue);

    /* Pour tout lire commenter le fread et décommenter le while */

    /*
    while(!feof($fp)) {
      $response.= fgetc($fp);
    }
    */

  fclose($fp);
  if ($errno) {
//    print("$errstr ($errno)<br>\n"); /* pour le debug */
    return null;
  }

//  print("\n<hr>\n$response\n<hr>\n"); /* pour le debug */

  return $response;
  }
}

function protomailto($to,$subject,$maildata,$from='',$cc='',$bcc='') {
  global $user_name, $user_passwd;

// Ce codage est celui qui est utilisé pour poster des informations dans les formulaires HTML.
// Le type MIME est application/x-www-form-urlencoded.

  $subject = urlencode($subject);
  $maildata = urlencode($maildata);

// inutile d'encoder les champs suivants
/*
  $to = urlencode($to);
  $from = urlencode($from);
  $cc = urlencode($cc);
  $bcc = urlencode($bcc);
*/

  // REQ1
  $message  = "GET / HTTP/1.0\r\n";
  $message .= "Host: imp.free.fr\r\n";
  $message .= "Accept: text/html, text/plain\r\n";
  $message .= "Accept-Language: en\r\n";
  $message .= "User-Agent: Lynx/2.8.4\r\n";
  $message .= "\r\n";
  $res = sendhttp($message,512);
  if ($res == null)
       return false;

  if (preg_match("/Horde=([^;]*);/sU", $res,$parts))
    $Horde = $parts[1];

  if (!$Horde)
    return false;

  $postdata = "actionID=105&url=&mailbox=INBOX&imapuser=$user_name&pass=$user_passwd&server=imap&folders=INBOX%2F&new_lang=en&button=Connexion";
  $postdatalen = strlen($postdata);

  // REQ4
  $message  = "POST /horde/imp/redirect.php?Horde=$Horde HTTP/1.1\r\n";
  $message .= "Host: imp.free.fr\r\n";
  $message .= "Accept: text/html, text/plain\r\n";
  $message .= "Accept-Language: en\r\n";
  $message .= "User-Agent: Lynx/2.8.4\r\n";
  $message .= "Content-type: application/x-www-form-urlencoded\r\n";
  $message .= "Content-length: $postdatalen\r\n";
  $message .= "\r\n";
  $message .= $postdata;

  $res = sendhttp($message,1);
  if ($res == null)
       return false;

  $uniq = urlencode(microtime());
  // POSTDATA
  $postdata = "actionID=114&thismailbox=INBOX&from=$from&to=$to&cc=$cc&bcc=$bcc&subject=$subject&message=$maildata";
  $postdatalen = strlen($postdata);

  $message  = "POST /horde/imp/compose.php?Horde=$Horde&uniq=$uniq HTTP/1.0\r\n";
  $message .= "Host: imp.free.fr\r\n";
  $message .= "Accept: text/html, text/plain\r\n";
  $message .= "Accept-Language: en\r\n";
  $message .= "User-Agent: Lynx/2.8.4\r\n";
  $message .= "Content-type: application/x-www-form-urlencoded\r\n";
  $message .= "Content-length: $postdatalen\r\n";
  $message .= "\r\n";
  $message .= "$postdata";
  $res = sendhttp($message,1);
  if ($res == null)
       return false;

  return true;
}

function proto_valid_email($str) {
  $mail_pat = '^(.+)@(.+)$';
  $valid_chars = "[^] \(\)<>@,;:\.\\\"\[]";
  $atom = "$valid_chars+";
  $word = "($atom)";
  $user_pat = "^$word(\.$word)*$";
  $ip_domain_pat='^\[([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\]$';
  $domain_pat = "^$atom(\.$atom)+$";

  if (eregi($mail_pat, $str, $components)) {
    $user = $components[1];
    $domain = $components[2];

    if (eregi($user_pat, $user)) {
       // validate domain
      if (eregi($ip_domain_pat, $domain)) return true;
      if (eregi($domain_pat, $domain)) return true;
    }
  }
  return false;
}

function protomail($to,$subject,$msg, $header = '', $additional='') {
  global $user_name;


  $email_from='';
  $email_cc='';
  $email_bcc='';

  $lines= explode("\n",$header);
  $lines_length = count($lines);
  for ($i=0;$i<$lines_length;$i++) {
    if (preg_match("/^From: (.*)\$/i", $lines[$i],$parts))
      $email_from = $parts[1];
    if (preg_match("/^Cc: (.*)\$/i", $lines[$i],$parts))
      $email_cc = $parts[1];
    if (preg_match("/^Bcc: (.*)\$/i", $lines[$i],$parts))
      $email_bcc = $parts[1];
  }
  if (!$email_from) $email_from = "$user_name@free.fr";

  $ret = protomailto($to,$subject,$msg,$email_from,$email_cc,$email_bcc);
  return $ret;
}

function protomail_clean() {
// La fonction protomail_clean ne remplit plus son rôle et ne sera pas remplacée. Vous ne devez plus l'utiliser

  return true;
}
?>