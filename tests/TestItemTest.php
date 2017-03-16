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
    public static $comparation_edition_token = "Edition text to save while testing";


	//public static $idOfLocationForCRUDTest = 5;

    protected function setUp() {

    }


   	/**
	 *	Check connected user can save an item
	 *
	 */

     public function testTestItemAddItem() {
    	$this->connect();
	   	$answer = apiQuickQueryWithToken(self::$url, 'testitem', 'save', array('testtext'=>self::$comparation_token), self::$token);
        $this->assertEquals(200, $answer->errorId);
        self::$testitem_id = $answer->data->id;
    	$this->disconnect();
    }


   	/**
	 *	Check the element is added and data match
	 *
	 */

     public function testTestItemViewCreated() {
    	$this->connect();
	   	$answer = apiQuickQueryWithToken(self::$url, 'testitem', 'view', array('id'=>self::$testitem_id), self::$token);
        $data = $answer->data->properties;
        $this->assertEquals(200, $answer->errorId);
        $this->assertEquals($data->testtext, self::$comparation_token);
    	$this->disconnect();
    }


    /**
	 *	Update ItemTest
	 *
	 */

     public function testTestItemUpdate() {
    	$this->connect();
	   	$answer = apiQuickQueryWithToken(self::$url, 'testitem', 'save', array('id'=>self::$testitem_id, 'testtext'=>self::$comparation_edition_token), self::$token);
        $this->assertEquals(200, $answer->errorId);
        $this->assertEquals("success", $answer->result);
    	$this->disconnect();
    }


    /**
	 *	Editing ItemTest
	 *
	 */

     public function testTestItemViewUpdated() {
    	$this->connect();
	   	$answer = apiQuickQueryWithToken(self::$url, 'testitem', 'view', array('id'=>self::$testitem_id), self::$token);
        $data = $answer->data->properties;
        $this->assertEquals(200, $answer->errorId);
        $this->assertEquals($data->testtext, self::$comparation_edition_token);
    	$this->disconnect();
    }


    /**
	 *	Deleting ItemTest
	 *
	 */

     public function testTestItemDelete() {
    	$this->connect();
	   	$answer = apiQuickQueryWithToken(self::$url, 'testitem', 'delete', array('id'=>self::$testitem_id), self::$token);
        $this->assertEquals(200, $answer->errorId);
    	$this->disconnect();
    }


    /**
	 *	Checking deletion ItemTest
	 *
	 */

     public function testTestItemViewDeleted() {
    	$this->connect();
	   	$answer = apiQuickQueryWithToken(self::$url, 'testitem', 'view', array('id'=>self::$testitem_id), self::$token);
        //var_dump($answer);
        $this->assertEquals(null, $answer->data->properties);
        $this->assertEquals(200, $answer->errorId);
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
