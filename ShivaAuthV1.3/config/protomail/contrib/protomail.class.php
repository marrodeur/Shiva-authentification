<?php
/*
* Licence GPL
* Auteur: Pierrick. <pbouliere@phpevolution.net>
* Auteur d'origine: Samuel KABAK, Codeas (http://www.codeas.net/)
*/

class Protomail {
	/* Class */
	var $ClassVersion = '1.1.1';

	/* Free servers */
	var $ServerIpArray = array('212.27.42.1', '212.27.42.2', '212.27.42.3', '212.27.42.4', '212.27.42.5', '212.27.42.6');
	var $ServerDns = 'imp.free.fr';
	var $UseDns    = false;
	var $NbRetry   = 6;

	/* Free Account */
	var $Username  = '';
	var $Password  = '';

	/* Free Email */
	var $From	 = array();
	var $To      = array();
	var $Cc      = array();
	var $Bcc     = array();
	var $ReplyTo = array();

	var $AddLine = "\r\n";

	function Protomail() {
		srand ((double) microtime()*10000000);
		$this->ServerIpIndex = array_rand($this->ServerIpArray);
	}

	function ProtomailSendHttp($Message, $Length = 2048) {
        if (!$this->UseDns) {
            $CountServerIpArray = count($this->ServerIpArray);
            $this->ServerIp =  $this->ServerIpArray[$this->ServerIpIndex];

            for($i=0; $i<$CountServerIpArray; $i++) {
              for($j=0; $j<$this->NbRetry; $j++) {
                $fp = fsockopen($this->ServerIp, 80, $errno, $errstr, 30);
                if($fp)
                  break;
              }
              if($fp)
                break;
              $this->ServerIpIndex = ($this->ServerIpIndex + 1) % $CountServerIpArray;
        	}
        } else {
		    for($j=0; $j<$this->NbRetry; $j++) {
              $fp = fsockopen($this->ServerDns, 80, $errno, $errstr, 30);
              if($fp)
                break;
            }
		}

        if(!$fp) {
        	return null;
        } else {
        	fputs($fp, $Message);
        	$response = fread($fp, $Length);
        	fclose($fp);
        	if ($errno) {
        		return null;
        	}
    		return $response;
		}
	}

    function ProtomailFrom($Email, $Name='') {
        $this->From['0'] = trim($Email);
        $this->From['1'] = $Name;
    }

    function ProtomailAddAddress($Email, $Name='') {
        $CountTo = count($this->To);
        $this->To[$CountTo]['0'] = trim($Email);
        $this->To[$CountTo]['1'] = $Name;
    }

    function ProtomailAddCc($Email, $Name='') {
        $CountCc = count($this->Cc);
        $this->Cc[$CountCc]['0'] = trim($Email);
        $this->Cc[$CountCc]['1'] = $Name;
    }

    function ProtomailAddBcc($Email, $Name='') {
        $CountBcc = count($this->Bcc);
        $this->Bcc[$CountBcc]['0'] = trim($Email);
        $this->Bcc[$CountBcc]['1'] = $Name;
    }

	function ProtomailListAddress($ListArray) {
		$ListEmailString = '';
		for($i=0; $i<count($ListArray); $i++) {
			$ListEmailString .= (!empty($ListArray[$i]['1'])) ? '"'. $ListArray[$i]['1'] .'" <'. $ListArray[$i]['0'] .'>,' : $ListArray[$i]['0'] .',';
		}
		return substr($ListEmailString, 0, strlen($ListEmailString)-1);
	}

	function ProtomailHTTPRequest($Url, $DataPost = '') {
		$DataPostString = '';
		if($DataPost) {
			if(is_array($DataPost)) {
				foreach($DataPost as $Key => $Values) {
					$DataPostString .= $Key .'='. $Values .'&';
				}
				$DataPostString = substr($DataPostString, 0, strlen($DataPostString)-1);
			} else {
				$DataPostString = $DataPost;
			}
			$DataPostLenght = strlen($DataPostString);
			$Method = 'POST';
		} else {
			$Method = 'GET';
		}

		$UrlPart = parse_url($Url);
		$HTTPRequest  = $Method . ((!empty($UrlPart['path'])) ? ' '. $UrlPart['path'] . ((isset($UrlPart['query'])) ? '?'. $UrlPart['query'] : '') : ' /')  .' '. $_SERVER['SERVER_PROTOCOL'] . $this->AddLine;
		$HTTPRequest .= 'Host: '. $UrlPart['host'] . $this->AddLine;
		$HTTPRequest .= 'Accept: text/html, text/plain' . $this->AddLine;
		$HTTPRequest .= 'Accept-Language: en' . $this->AddLine;
		$HTTPRequest .= 'User-Agent: Lynx/2.8.4' . $this->AddLine;

		if($Method == 'POST') {
        	$HTTPRequest .= 'Content-type: application/x-www-form-urlencoded' . $this->AddLine;
        	$HTTPRequest .= 'Content-length: '. $DataPostLenght . $this->AddLine;
		}

		$HTTPRequest .= $this->AddLine;
		if($Method == 'POST') {
        	$HTTPRequest .= $DataPostString;
		}

		return $HTTPRequest;
	}

	function ProtomailSend() {
		if(!$this->Username OR !$this->Password) {
			$this->Error = 'IMP statut : Login/Password invalid';
			return false;
		}

		// Le type MIME est application/x-www-form-urlencoded.
		$this->FromString = ($this->From) ? ((!empty($this->From['1'])) ? '"'. $this->From['1'] .'" <'. $this->From['0'] .'>' : $this->From['0']) : $Username . '@free.fr';
		$this->ToString = $this->ProtomailListAddress($this->To);
		$this->CcString = $this->ProtomailListAddress($this->Cc);
		$this->BccString = $this->ProtomailListAddress($this->Bcc);
		$this->SubjectString = urlencode($this->Subject);
		$this->BodyString = urlencode($this->Body);

		// REQ1
		/* Debug
		echo '<strong>REQ1</strong> : <br/>' . $this->AddLine;
		echo 'Request headers' . $this->AddLine;
		echo '<pre>'. $this->ProtomailHTTPRequest('http://imp.free.fr') . '</pre>' . $this->AddLine;
		$Result = $this->ProtomailSendHttp($this->ProtomailHTTPRequest('http://imp.free.fr'), 512);
		Fin Debug */

		$Result = $this->ProtomailSendHttp($this->ProtomailHTTPRequest('http://imp.free.fr'), 512);

		/* Debug
		echo 'Response headers' . $this->AddLine;
		echo '<pre>'. $Result . '</pre>' . $this->AddLine;
		echo '<hr/>' . $this->AddLine;
		Fin Debug */

		if($Result == null) {
			$this->Error = 'Cannot Execute HTTP request REQ1';
			return false;
		}

		if (preg_match('/Horde=([^;]*);/sU', $Result, $parts))
		$Horde = $parts['1'];
		if (!$Horde) {
			$this->Error = 'Cannot get horde variable';
			return false;
		}

		$DataPost = array(	'actionID' => 105,
							'url' => '',
							'mailbox' => 'INBOX',
							'imapuser' => $this->Username,
							'pass' => $this->Password,
							'server' => 'imap',
							'folders' => 'INBOX%2F',
							'new_lang' => 'en',
							'button' => 'Connexion'
						 );

		// REQ4
		/* Debug
		echo '<strong>REQ4</strong> : <br/>';
		echo 'Request headers' . $this->AddLine;
		echo '<pre>'. $this->ProtomailHTTPRequest('http://imp.free.fr/horde/imp/redirect.php?Horde='. $Horde, $DataPost) . '</pre>' . $this->AddLine;
		$Result = $this->ProtomailSendHttp($this->ProtomailHTTPRequest('http://imp.free.fr/horde/imp/redirect.php?Horde='. $Horde, $DataPost), 512);
		Fin Debug */

		$Result = $this->ProtomailSendHttp($this->ProtomailHTTPRequest('http://imp.free.fr/horde/imp/redirect.php?Horde='. $Horde, $DataPost), 512);

		/* Debug
		echo 'Response headers' . $this->AddLine;
		echo '<pre>'. $Result . '</pre>' . $this->AddLine;
		echo '<hr/>' . $this->AddLine;
		Fin Debug */

		if ($Result == null) {
			$this->Error = 'Cannot execute HTTP request REQ4';
			return false;
		}

		if (preg_match('`reason=([a-zA-Z]*)`', $Result, $parts))
		$Reason = trim($parts['1']);

        switch ($Reason) {
            case 'failed':
				$this->Error = 'IMP statut : Login/Password invalid';
				return false;
                break;
            case 'session':
				$this->Error = 'IMP statut : Session destroyed';
				/* Possibilité : Relancer l'authentification */
				return false;
                break;
            case 'logout':
				$this->Error = 'IMP statut : Logout';
				/* Possibilité : Relancer l'authentification */
				return false;
                break;
        }

		$DataPost = array(	'actionID' => 114,
							'thismailbox' => 'INBOX',
							'from' => $this->FromString,
							'to' => $this->ToString,
							'cc' => $this->CcString,
							'bcc' => $this->BccString,
							'subject' => $this->SubjectString,
							'message' => $this->BodyString
						);
		// POSTDATA
		/* Debug
		echo '<strong>POSTDATA</strong> : <br/>' . $this->AddLine;
		echo 'Request headers' . $this->AddLine;
		echo '<pre>'. $this->ProtomailHTTPRequest('http://imp.free.fr/horde/imp/compose.php?Horde='. $Horde .'&uniq='. urlencode(microtime()), $DataPost) . '</pre>' . $this->AddLine;
		$Result = $this->ProtomailSendHttp($this->ProtomailHTTPRequest('http://imp.free.fr/horde/imp/compose.php?Horde='. $Horde .'&uniq='. urlencode(microtime()), $DataPost), 512);
		Fin Debug */

		$Result = $this->ProtomailSendHttp($this->ProtomailHTTPRequest('http://imp.free.fr/horde/imp/compose.php?Horde='. $Horde .'&uniq='. urlencode(microtime()), $DataPost), 1);

		/* Debug
		echo 'Response headers' . $this->AddLine;
		echo '<pre>'. $Result . '</pre>' . $this->AddLine;
		echo '<hr/>' . $this->AddLine;
		Fin Debug */

		if ($Result == null) {
			$this->Error = 'Cannot execute HTTP request POSTDATA';
			return false;
		}

		return true;
	}
}

?>