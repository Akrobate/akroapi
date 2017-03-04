<?php

include_once("functions.php");

$url = API_URL;

const DATAPATH = "data/users.txt";
const NBRUSERS = 100;

$alldatas = array();

for ($i=0; $i < NBRUSERS; $i++) {
	$usr = AddAUser();
	$dt = array();
	$dt['id'] = $usr['id'];
	$dt['email'] = $usr['email'];
	$dt['password'] = $usr['password'];
	$alldatas[] = $dt;
	print_r($dt);
}

$out = json_encode($alldatas);
file_put_contents(DATAPATH, $out);


/**
 *	Methode de test d'acces publique a la page
 *	users / access
 *
 */

function AddAUser() {
	global $url;
	$msg = array();
	$msg['module'] = 'users';
	$msg['action'] = 'add';
	
	$str = file_get_contents("http://api.randomuser.me/");
	$obj = json_decode($str);
	$user = $obj->results[0]->user;

	$nom = ucfirst($user->name->last);
	$prenom = ucfirst($user->name->first);

	$object = array();
//	$object->name =  $prenom . " " . $nom;
	$object['firstname'] = $prenom;
	$object['lastname'] = $nom;
	$object['email'] = $user->email;
	$object['usertype'] = "employe";
	$object['phone'] = $user->phone;
	$object['status'] = "registred";
	$object['password'] = md5(rand(1,1000) . " " . rand(1,1000));
	$object['photourl'] = $user->picture->large;

//	$object->ville = $user->location->city;
//	$object->adresse = $user->location->street;
//	$object->cp = $user->location->zip;
//	$object->cp_ville = $user->location->zip . " " . $user->location->city;

	$msg['params'] = $object;
	//$query = json_encode($msg);
	//print_r($msg);




//	$str = curlPostQuery($url, $query);
	//echo($str);
//	$users = json_decode($str);


	$users = apiQuickQuery($url, 'users', 'add', $object);
	
	//print_r($users);

	$uid = 0;
	
	if ($users->errorId != 404) {		
		$uid = $users->data->id;
	}
	
	$object['id'] = $uid;

	return $object;
	
}
    

