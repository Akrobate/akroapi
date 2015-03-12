<?php

	// DO NOT FORGET: "LESS IS MORE"
	session_start();
	
	require_once("./api.php");
	$rq = request::getPostJSON();
	var_dump($rq);
	
	$ctr = new Controller();
	$ctr->setAction($rq->action);
	$ctr->setModule($rq->module);
	$ctr->setParams(@$rq->params);
	$ctr->setFormat("json");
	
	//debug
	//print_r($ctr->getArray());
	
	$ctr->renderJSON();
