<?php


/*
  {
    "action": "getContactData",
    "result": "success",
    "errorId": 200,
    "errorDescription": "",
    "debug": "",
    "session": {
      "appUserExpiration": 180
    },
    "data": {
      "contactData": [
        {
          "idpersonne": 179687,
          "idfonction": 195432,
          "lastUpdate": 0,
          "fullName": "Civilité Prénom Nom",
          "firstname": "Prénom",
          "name": "Nom",
          "civilite": "Civilité",
          "active": true,
          "company": "Nom de l'établissement",
          "poste": "Directeur financier",
          "coordonnees": "htmlstring",
          "responsabilites": "htmlstring",
          "parcours": "htmlstring",
          "photo": false,
          "isfavori": true
        }
      ]
    }
  }
*/


$msg = array(
	'action' => 'getwords',
	'result' => 'success',
	'errorId' => 200,
	'action' => 'getwords',
	"data" => array(
		"words" => array(
			array(
				"id"=>24,
				"text"=>"Test rapide"
			),
			array(
				"id"=>25,
				"text"=>"Test rapide 2"
			)
		)
	
	)
);

//print_r ($msg);


echo(json_encode($msg));
