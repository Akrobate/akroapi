<?php

include_once("tests/functions.php");

class WordsTest extends PHPUnit_Framework_TestCase {

	public static $url = "http://localhost/dropaword/";

//	public static $url = "http://89.156.94.6/dropaword/";
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
    
    
    public function testSaveAnItem() {
    	$msg = self::$message;
    	$msg['action'] = 'save';
    	$msg['params']['text'] = "Mon test insert par id_ownere";
    	$msg['params']['longitude'] = 3.56;
    	$msg['params']['latitude'] = 2.45;
    	$msg['params']['altitude'] = 12.34;
    	$msg['params']['id_owner'] = 2;
		$query = json_encode($msg);
    	echo(curlPostQuery(self::$url, $query));
    }
    

    public function testSaveAndUserCreate() {
    	$msg = self::$message;
    	$msg['action'] = 'save';
    	$msg['params']['text'] = "Mon test insert par hash";
    	$msg['params']['longitude'] = 3.56;
    	$msg['params']['latitude'] = 2.45;
    	$msg['params']['altitude'] = 12.34;
    	$msg['params']['hash'] = "FROMTESTUSER" . rand(1,20);
		$query = json_encode($msg);
    	echo(curlPostQuery(self::$url, $query));
    }

/*
 	public function testSaveForSearchTMPUserCreate() {
    	$msg = self::$message;
    	$msg['action'] = 'save';
    	$msg['params']['text'] = "Mon test insert par tests";
    	$msg['params']['longitude'] = 5.700000;
    	$msg['params']['latitude'] = 2.000000;
    	$msg['params']['altitude'] = 2.30000;
    	$msg['params']['hash'] = "FROMTESTUSER" . rand(1,20);
		$query = json_encode($msg);
    	echo(curlPostQuery(self::$url, $query));
    }
*/

    public function testSearch() {
    	$msg = self::$message;
    	$msg['action'] = 'search';
    	$msg['params']['longitude'] = 5.700000;
    	$msg['params']['latitude'] = 2.000000;
    	$msg['params']['altitude'] = 2.30000;
		$query = json_encode($msg);
    	echo(curlPostQuery(self::$url, $query));
    }
    
    
    
     public function testTrashs() {
    	$msg = self::$message;
    	$msg['action'] = 'trash';
    	$msg['params']['hash'] = "FROMTESTUSER" . rand(1,20);
		$msg['params']['id'] = rand(1,10);
		$query = json_encode($msg);
    	echo(curlPostQuery(self::$url, $query));
    }
    
    
    
    public function testBookmark() {
    	$msg = self::$message;
    	$msg['action'] = 'bookmark';
    	$msg['params']['hash'] = "FROMTESTUSER" . rand(1,20);
		$msg['params']['id'] = rand(1,10);
		$query = json_encode($msg);
    	echo(curlPostQuery(self::$url, $query));
    }


    protected function tearDown() {


    }
}

