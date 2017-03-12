<?php

include_once("functions.php");

class RestrictedTestItemTest extends PHPUnit_Framework_TestCase {

	public static $url = API_URL;
	public static $token = null;
	public static $nbrTestItemMine = 3;
	public static $nbrTestItemTotal = 33;
//	public static $nbrTestItemMine = 4;

    public static $testitem_id = null;
    public static $comparation_token = "Text to save while testing";
    public static $comparation_edition_token = "Edition text to save while testing";

    public static $users = [
        'A' => [
            'login' => "user4",
            'password' => "987"
        ],
        'B' => [
            'login' => "user5",
            'password' => "987"
        ],

    ];

	//public static $idOfLocationForCRUDTest = 5;

    protected function setUp() { }


   	/**
	 *	On Connecte l'utilisateur et on recuper les skills
	 *	users / access
	 *
	 */

     public function testTestItemAddItem() {
    	self::$token = connect(self::$users['A']['login'], self::$users['A']['password'], self::$token);
        // var_dump( self::$token);
	   	$answer = apiQuickQueryWithToken(self::$url, 'testitem', 'save', array('testtext'=>self::$comparation_token), self::$token);
        $this->assertEquals(200, $answer->errorId);
        self::$testitem_id = $answer->data->id;
        // var_dump(self::$testitem_id);
    	disconnect(self::$token);
    }


   	/**
	 *	Check the element is added and data match
	 *
	 */

     public function testTestItemViewCreated() {
        self::$token = connect(self::$users['A']['login'], self::$users['A']['password'], self::$token);
	   	$answer = apiQuickQueryWithToken(self::$url, 'testitem', 'view', array('id'=>self::$testitem_id), self::$token);
        $data = $answer->data->properties;
        // print_r($data);
        // var_dump($answer);
        $this->assertEquals(200, $answer->errorId);
        $this->assertEquals($data->testtext, self::$comparation_token);
    	disconnect(self::$token);
    }


    /**
	 *	Update ItemTest
	 *
	 */

     public function testTestItemUpdate() {
    	self::$token = connect(self::$users['A']['login'], self::$users['A']['password'], self::$token);
	   	$answer = apiQuickQueryWithToken(self::$url, 'testitem', 'save', array('id'=>self::$testitem_id, 'testtext'=>self::$comparation_edition_token), self::$token);
        // $data = $answer->data->properties;
        // print_r($data);
        // var_dump($answer);
        $this->assertEquals(200, $answer->errorId);
        $this->assertEquals("success", $answer->result);
        disconnect(self::$token);
    }


    /**
	 *	Editing ItemTest
	 *
	 */

     public function testTestItemViewUpdated() {
    	self::$token = connect(self::$users['A']['login'], self::$users['A']['password'], self::$token);
	   	$answer = apiQuickQueryWithToken(self::$url, 'testitem', 'view', array('id'=>self::$testitem_id), self::$token);
        $data = $answer->data->properties;
        // print_r($data);
        // var_dump($answer);
        $this->assertEquals(200, $answer->errorId);
        $this->assertEquals($data->testtext, self::$comparation_edition_token);
    	disconnect(self::$token);
    }


    /**
	 *	Deleting ItemTest
	 *
	 */

     public function testTestItemDelete() {
    	self::$token = connect(self::$users['A']['login'], self::$users['A']['password'], self::$token);
	   	$answer = apiQuickQueryWithToken(self::$url, 'testitem', 'delete', array('id'=>self::$testitem_id), self::$token);
        $this->assertEquals(200, $answer->errorId);
    	disconnect(self::$token);
    }


    /**
	 *	Checking deletion ItemTest
	 *
	 */

     public function testTestItemViewDeleted() {
    	self::$token = connect(self::$users['A']['login'], self::$users['A']['password'], self::$token);
	   	$answer = apiQuickQueryWithToken(self::$url, 'testitem', 'view', array('id'=>self::$testitem_id), self::$token);
        //var_dump($answer);
        $this->assertEquals(null, $answer->data->properties);
        $this->assertEquals(200, $answer->errorId);
    	disconnect(self::$token);
    }


    protected function tearDown() {


    }


}
