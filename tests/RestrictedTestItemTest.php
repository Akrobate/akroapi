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

    public static $testitem_id_A = null;
    public static $testitem_id_B = null;

    public static $users = [
        'A' => [
            'login' => "user4",
            'password' => "987",
            'comparation_token' => "Text owned by user A to save while testing"
        ],
        'B' => [
            'login' => "user5",
            'password' => "987",
            'comparation_token' => "Text owned by user B to save while testing"
        ],

    ];

	//public static $idOfLocationForCRUDTest = 5;

    protected function setUp() { }


   	/**
	 *	UserA created an item with its value of comparation_token
	 *	users / access
	 *
	 */

     public function testAddItemUserA() {
    	self::$token = connect(self::$users['A']['login'], self::$users['A']['password'], self::$token);
	   	$answer = apiQuickQueryWithToken(self::$url, 'testitemrestricted', 'mysave', array('testtext' => self::$users['A']['comparation_token'] ), self::$token);
        $this->assertEquals(200, $answer->errorId);
        self::$testitem_id = $answer->data->id;
    	disconnect(self::$token);
    }


   	/**
	 *	UserB try to view the itemId created by UserA
	 *  Should not be able to view content
	 */

     public function testAsBViewCreatedByA() {
        self::$token = connect(self::$users['B']['login'], self::$users['B']['password']);
	   	$answer = apiQuickQueryWithToken(self::$url, 'testitemrestricted', 'myview', array('id'=>self::$testitem_id), self::$token);
        $data = $answer->data->properties;
        // var_dump($answer);
        $this->assertEquals(200, $answer->errorId);
        $this->assertEquals(NULL, $data);
    	disconnect(self::$token);
    }



    /**
	 *	Check UserA can see the content created by himslef
	 *  Should be able to
	 */

     public function testAsAViewCreatedByA() {
    	self::$token = connect(self::$users['A']['login'], self::$users['A']['password'], self::$token);
	   	$answer = apiQuickQueryWithToken(self::$url, 'testitemrestricted', 'myview', array('id'=>self::$testitem_id), self::$token);
        $data = $answer->data->properties;
        // var_dump($answer);
        $this->assertEquals(200, $answer->errorId);
        $this->assertEquals(self::$users['A']['comparation_token'], $data->testtext );
        disconnect(self::$token);
    }


    /**
	 *	Check UserB remove users A item
	 *  Should not be abble to
	 */

     public function testAsBRemoveCreatedByA() {
    	self::$token = connect(self::$users['B']['login'], self::$users['B']['password'], self::$token);
	  	$answer = apiQuickQueryWithToken(self::$url, 'testitemrestricted', 'mydelete', array('id'=>self::$testitem_id), self::$token);
        // print_r($data);
        // var_dump($answer);
        $this->assertEquals(false, $answer->data->deleted);
    	disconnect(self::$token);
    }


    /**
	 *	Check UserA Can still read Item created by himself
	 *	(after UserB Tryed to remove it)
	 *	Sould be able to
	 *
	 */

    public function testUserACanStillReadHisItem() {
        self::$token = connect(self::$users['A']['login'], self::$users['A']['password'], self::$token);
        $answer = apiQuickQueryWithToken(self::$url, 'testitemrestricted', 'myview', array('id'=>self::$testitem_id), self::$token);
        $data = $answer->data->properties;
        // var_dump($answer);
        $this->assertEquals(200, $answer->errorId);
        $this->assertEquals(self::$users['A']['comparation_token'], $data->testtext );
        disconnect(self::$token);
    }


    /**
     *	Check UserB remove users A item
     *  Should not be abble to
     */

     public function testAsARemoveCreatedByA() {
    	self::$token = connect(self::$users['A']['login'], self::$users['A']['password'], self::$token);
		$answer = apiQuickQueryWithToken(self::$url, 'testitemrestricted', 'mydelete', array('id'=>self::$testitem_id), self::$token);
		// var_dump($answer);
		$this->assertEquals(false, $answer->data->deleted);

    	disconnect(self::$token);
    }


    protected function tearDown() {


    }


}
