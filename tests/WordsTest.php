<?php

include_once("tests/functions.php");

class WordsTest extends PHPUnit_Framework_TestCase {

	public static $url = "http://localhost/dropaword/";

	public static $message = array(
		'action'=>'',
		'module'=>'words'
	);

    protected function setUp() {
      
    }


    public function testGetWord() {
    	$msg = self::$message;
    	$msg['action'] = 'index';
		$query = json_encode($msg);
    	echo(curlPostQuery(self::$url, $query));
    }

/*
    public function testTwo() {
		//$url = "http://localhost/dropaword/";
	    $data = array("name" => "Hagridqqqq", "age" => "360");
		$query = json_encode($data);
    	echo(curlPostQuery2(self::$url, $query));
    }
*/

   public function testEmptyAction() {
    	$msg = self::$message;
    	$msg['action'] = '';
		$query = json_encode($msg);
    	echo(curlPostQuery(self::$url, $query));
    }


    protected function tearDown() {


    }
}

