<?php

	// DO NOT FORGET: "LESS IS MORE"
	session_start();
	
	
	//require_once("./api.php");
	
	var_dump($_POST);
	var_dump(file_get_contents("php://input"));
	
	exit();
	
	
	$ctr = new Controller();
	$ctr->setAction(request::get("action"));
	$ctr->setModule(request::get("controller"));
//	$ctr->setFormat(request::get("format"));
	$ctr->setFormat("json");
	$ctr->renderJSON();
