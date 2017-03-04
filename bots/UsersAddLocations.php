<?php

include_once("functions.php");

$url = API_URL;

const DATAPATH = "data/users.txt";
const NBRUSERS = 10;




$strin = file_get_contents(DATAPATH);
$allusers = json_decode($strin);

$alllocations = array();


foreach($allusers as $user) {

	$answer = apiQuickQuery($url, 'users', 'login', array('login'=>$user->email, 'password'=>$user->password));

	print_r($answer);

	if (count($alllocations) == 0) {
		$answer = apiQuickQuery($url, 'locations', 'getall');
		$alllocations = $answer->data->locations;
	}

	$nbrskills = count($alllocations);
	
	$locationstoadd = array();

	while(count($locationstoadd) < 2) {
		$rsel = rand(0,($nbrskills-1));
		if (!in_array($rsel, $locationstoadd)){
			$locationstoadd[] = $rsel;
		}
	}

	print_r($locationstoadd);

	foreach ($locationstoadd as $k) {
		$answer = apiQuickQuery($url, 'users', 'addlocation', array('id'=>$alllocations[$k]->id));
		print_r($answer);
	}	
	
	$answer = apiQuickQuery($url, 'users', 'logout');
	print_r($answer);
	

}

