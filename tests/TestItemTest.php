<?php

include_once("functions.php");

class TestItemTest extends PHPUnit_Framework_TestCase {

	public static $url = API_URL;
	public static $token = null;
	public static $nbrTestItemMine = 3;
	public static $nbrTestItemTotal = 33;
//	public static $nbrTestItemMine = 4;

    public static $testitem_id = null;
    public static $comparation_token = "Text to save while testing";


	//public static $idOfLocationForCRUDTest = 5;

    protected function setUp() {

    }


   	/**
	 *	On Connecte l'utilisateur et on recuper les skills
	 *	users / access
	 *
	 */

     public function testTestItemAddItem() {
    	$this->connect();

        var_dump( self::$token);

	   	$answer = apiQuickQueryWithToken(self::$url, 'testitem', 'save', array('testtext'=>self::$comparation_token), self::$token);

        $this->assertEquals(200, $answer->errorId);

        self::$testitem_id = $answer->data->id;
        var_dump(self::$testitem_id);
        //$this->assertEquals( self::$nbrTestItemTotal, count($answer->data->testitem));
    	$this->disconnect();
    }


   	/**
	 *	On Connecte l'utilisateur et on recuper les skills
	 *	users / access
	 *
	 */

     public function testTestItemViewCreated() {
    	$this->connect();
        // var_dump( self::$token);
        //

        echo("================");
        echo(self::$testitem_id);
        echo("================");

	   	$answer = apiQuickQueryWithToken(self::$url, 'testitem', 'view', array('id'=>self::$testitem_id), self::$token);
        // $data = $answer->data->listContent[0];
        //print_r($data);
        var_dump($answer);
        $this->assertEquals(200, $answer->errorId);
        // $this->assertEquals($data->testtext, self::$comparation_token);
    	$this->disconnect();
    }

    protected function tearDown() {


    }


   private function connect() {
	    $answer = apiQuickQueryWithToken(self::$url, 'users', 'login', array('login'=>'skillstester', 'password'=>'987'), self::$token);
		self::$token = $answer->token;
		$this->assertEquals($answer->errorId, 200);
		$this->assertEquals($answer->data->status, 'connected');
    }


    private function disconnect() {
	    $answer = apiQuickQueryWithToken(self::$url, 'users', 'logout', array(), self::$token);
		$this->assertEquals($answer->errorId, 200);
		$this->assertEquals($answer->data->status, 'logout');
    }


    private function checkConnected() {
	    $answer = apiQuickQueryWithToken(self::$url, 'users', 'access', array(), self::$token);
		$this->assertEquals($answer->errorId, 200);
		if ($answer->data->connected == 'yes') {
			return true;
		} else {
			return false;
		}
    }
}
