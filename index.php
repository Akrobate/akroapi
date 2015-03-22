<?php


	// DO NOT FORGET: "LESS IS MORE"

	header('Content-Type: text/html; charset=utf-8');

	date_default_timezone_set("Europe/Paris"); 
	session_start();

//	mb_internal_encoding("UTF-8");

//	 mb_http_output( "UTF-8" );
	
	require_once("./api.php");
	$rq = request::getPostJSON();
	

	file_put_contents ("console.log", print_r($rq,1),  FILE_APPEND);
	
	$ctr = new Controller();
	$ctr->setAction(@$rq->action);
	$ctr->setModule(@$rq->module);
//	$ctr->setParams(request::ut8ParamsEncode(@$rq->params));

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

	file_put_contents ("console.log", print_r($ctr->getData(),1),  FILE_APPEND);

