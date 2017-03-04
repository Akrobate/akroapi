<?php

include_once("functions.php");

$url = API_URL;

const DATAPATH = "data/users.txt";

while(1) {
	mainLoop(1);
}


function mainLoop($sleep = 1) {

	global $url;
	$strin = file_get_contents(DATAPATH);
	$allusers = json_decode($strin);
	
	foreach($allusers as $user) {

		sleep($sleep);
		$answer = apiQuickQuery($url, 'users', 'login', array('login'=>$user->email, 'password'=>$user->password), true);

		$answer = apiQuickQuery($url, 'offers', 'getmines');
		//print_r($answer);
	
		$offers = $answer->data->offers;
	
		$offersAccepted = array();
		$offersToAccept = array();	
	
		foreach($offers as $offer) {
			if ($offer->accepted == true) {
				$offersAccepted[] = $offer;
			} else {
				$offersToAccept[] = $offer;
			}
		}
	
		$nbrOffersToAccept = count($offersToAccept);

		if ($nbrOffersToAccept > 0) {

			$rsel = rand(0, ($nbrOffersToAccept - 1));
			$answer = apiQuickQuery($url, 'offers', 'answer', array('id'=>$offersToAccept[$rsel]->id_offer, 'answer' => "accepted"), true);
			//print_r($answer);	
			echo("On Accepte une offre\n");
		} else {
			echo("Aucune offre a accepter\n");
		}

		echo("Total : ". count($offers) ." -  Acceptables : ". count($offersToAccept) . " - Who : " . $user->email . " \n ");
	
		$answer = apiQuickQuery($url, 'users', 'logout');
		//exit();
	}
}

