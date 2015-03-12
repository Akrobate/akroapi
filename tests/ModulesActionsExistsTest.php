<?php

include_once("tests/functions.php");

class ModulesActionsExistsTest extends PHPUnit_Framework_TestCase {

	public static $url = "http://localhost/dropaword/";

	public static $message = array(
		'action'=>'',
		'module'=>''
	);

    protected function setUp() {
      
    }
/*
    public function testModuleWords() {
    	$msg = self::$message;
    	$msg['action'] = 'index';
    	$msg['module'] = 'words';
		$query = json_encode($msg);
    	echo(curlPostQuery(self::$url, $query));
    }

    public function testModuleWords() {
    	$msg = self::$message;
    	$msg['action'] = 'index';
    	$msg['module'] = 'words';
		$query = json_encode($msg);
    	echo(curlPostQuery(self::$url, $query));
    }
*/
    protected function tearDown() {


    }
}

