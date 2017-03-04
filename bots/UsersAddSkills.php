<?php

include_once("functions.php");

$url = API_URL;
const DATAPATH = "data/users.txt";

$strin = file_get_contents(DATAPATH);
$allusers = json_decode($strin);
$allskills = array();

foreach($allusers as $user) {

	$answer = apiQuickQuery($url, 'users', 'login', array('login'=>$user->email, 'password'=>$user->password));
	print_r($answer);
	if (count($allskills) == 0) {
		$answer = apiQuickQuery($url, 'skills', 'getall');
		$allskills = $answer->data->skills;
	}

	$nbrskills = count($allskills);
	$skillstoadd = array();
	while(count($skillstoadd) < 2) {
		$rsel = rand(0,($nbrskills-1));
		if (!in_array($rsel, $skillstoadd)){
			$skillstoadd[] = $rsel;
		}
	}
	print_r($skillstoadd);
	foreach ($skillstoadd as $k) {
		$answer = apiQuickQuery($url, 'users', 'addskill', array('id'=>$allskills[$k]->id));
		print_r($answer);
	}	

	$answer = apiQuickQuery($url, 'users', 'logout');
	print_r($answer);
	

}

