<?php

	// DO NOT FORGET: "LESS IS MORE"
	session_start();
	
	require_once("./api.php");
	$rq = request::getPostJSON();
	
	
	$ctr = new Controller();
	$ctr->setAction(@$rq->action);
	$ctr->setModule(@$rq->module);
	$ctr->setParams(@$rq->params);
	$ctr->setFormat("json");
	
	
	//debug
	if ($ctr->getDebug()) {
		
		$arr = $ctr->getArray();
	
		var_dump($rq);
		print_r($arr);
	} else {
	
		$ctr->renderJSON();
	}
