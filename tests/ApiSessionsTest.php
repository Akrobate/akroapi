<?php

include_once("functions.php");

class ApiSessionsTest extends PHPUnit_Framework_TestCase {

	public static $url = API_URL;
	public static $token = null;

	public static $message = array(
		'action'=>'',
		'module'=>'users'
	);

    protected function setUp() {

    }


 	public function testGetAccesses() {
		$answer = apiQuickQueryWithToken(self::$url, 'users', 'access', array(), self::$token, false);
		//var_dump($answer);
		//print_r($answer);
		self::$token = $answer->token;
		//echo(self::$token);
		$exists = false;

		$this->assertEquals(32, strlen(self::$token));
    }


 	public function testGetAccessesTwice() {
		$answer = apiQuickQueryWithToken(self::$url, 'users', 'access', array(), self::$token, false);
		//print_r($answer);
		$token = $answer->token;
		$this->assertEquals(self::$token, $token);
    }


    protected function tearDown() {

    }


    private function connect() {
    	$answer = apiQuickQuery(self::$url, 'users', 'login', array('login'=>'skillstester', 'password'=>'987'));
		$this->assertEquals(200, $answer->errorId);
		$this->assertEquals($answer->data->status, 'connected');
    }


    private function disconnect() {
	    $answer = apiQuickQuery(self::$url, 'users', 'logout');
		$this->assertEquals($answer->errorId, 200);
		$this->assertEquals($answer->data->status, 'logout');

    }


    private function checkConnected() {
	    $answer = apiQuickQuery(self::$url, 'users', 'access');
	//	print_r($answer);
		$this->assertEquals($answer->errorId, 200);

		if ($answer->data->connected == 'yes') {
			return true;
		} else {
			return false;
		}
    }
}
