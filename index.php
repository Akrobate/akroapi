<?php


	// DO NOT FORGET: "LESS IS MORE"

	header('Content-Type: text/html; charset=utf-8');

	date_default_timezone_set("Europe/Paris");
    require_once("./api.php");
	//session_start();
	$rq = request::getPostJSON();

//	print_r(@$rq);

	if (!isset($rq->token)) {
		$token = session::start();
	} else {
		$token = session::start(@$rq->token);
	}

	// file_put_contents ("console.log", print_r($rq,1),  FILE_APPEND);
	$ctr = new Controller();
	$ctr->setAction(@$rq->action);
	$ctr->setModule(@$rq->module);
	// $ctr->setParams(request::ut8ParamsEncode(@$rq->params));

	$ctr->setParams(@$rq->params);
	$ctr->setFormat("json");
	$ctr->assign('token', $token);

	//debug
	if ($ctr->getDebug()) {
		$arr = $ctr->getArray();
		var_dump($rq);
		print_r($arr);
	} else {
		$ctr->renderJSON();
	}

	//print_r(session::$data);

	session::writeclose($token);

	//	file_put_contents ("console.log", print_r($ctr->getData(),1),  FILE_APPEND);
