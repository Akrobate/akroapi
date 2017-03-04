<?php

const API_URL = "http://localhost/server/";

$cookies_file = "./tests/coockies/coockies.txt";


/**
 *	VErsion avec cookies pour sessions
 *	non necessaire pour la version state less
 *
 */



function curlPostQuery($url, $query) {
	global $cookies_file;

	//echo($cookies_file);

	$data_string = $query;

	$useragent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2';

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );

	if (!file_exists($cookies_file)) {
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
	}

	// Fichier dans lequel cURL va lire les cookies
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookies_file);
	curl_setopt( $ch, CURLOPT_COOKIEFILE, $cookies_file );
	curl_setopt( $ch, CURLOPT_USERAGENT, $useragent );

	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($data_string))
	);

	$result = curl_exec($ch);
	return $result;
}


/**
 *	ANcienne version qui marche pas
 *	car ne tient pas compte des cookies
 *
 */

function curlPostQuery2($url, $data_json) {


	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result  = curl_exec($ch);
	curl_close($ch);
	return $result;
}


function apiQuickQuery($url, $module, $action, $params = array(), $echo = false) {
	  	$msq = array();
    // On se connecte
    	$msg['module'] = $module;
    	$msg['action'] = $action;
    	$msg['params'] = $params;
		$query = json_encode($msg);

		$answerstr = curlPostQuery($url, $query);


		$answer = json_decode($answerstr);

		if ($echo) {
			echo($answerstr);
			print_r($answer);
		}


		return $answer;
}


function apiQuickQueryWithToken($url, $module, $action, $params = array(), $token = "", $echo = false) {
	  	$msq = array();
    // On se connecte
    	$msg['module'] = $module;
    	$msg['action'] = $action;
    	$msg['params'] = $params;
    	$msg['token'] = $token;
		$query = json_encode($msg);

		$answerstr = curlPostQuery2($url, $query);

		$answer = json_decode($answerstr);

		if ($echo) {
			echo($answerstr);
			print_r($answer);
		}

		return $answer;
}
