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

    public static $set_of_elements = array();

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
		//var_dump($answer);
		$this->assertEquals(true, $answer->data->deleted);
    	disconnect(self::$token);
    }


    //      ____                            _         ____
    //     / ___|  ___ ___ _ __   __ _ _ __(_) ___   |___ \
    //     \___ \ / __/ _ \ '_ \ / _` | '__| |/ _ \    __) |
    //      ___) | (_|  __/ | | | (_| | |  | | (_) |  / __/
    //     |____/ \___\___|_| |_|\__,_|_|  |_|\___/  |_____|
    //

    /**
     *	UserB creates 3 items
     *
     */

     public function testAdd3ItemsUserB() {
        self::$token = connect(self::$users['B']['login'], self::$users['B']['password'], self::$token);

        $answer = apiQuickQueryWithToken(self::$url, 'testitemrestricted', 'mysave', array('testtext' => self::$users['A']['comparation_token'] ), self::$token);
        $this->assertEquals(200, $answer->errorId);
        self::$set_of_elements[] = $answer->data->id;

        $answer = apiQuickQueryWithToken(self::$url, 'testitemrestricted', 'mysave', array('testtext' => self::$users['A']['comparation_token'] ), self::$token);
        $this->assertEquals(200, $answer->errorId);
        self::$set_of_elements[] = $answer->data->id;

        $answer = apiQuickQueryWithToken(self::$url, 'testitemrestricted', 'mysave', array('testtext' => self::$users['A']['comparation_token'] ), self::$token);
        $this->assertEquals(200, $answer->errorId);
        self::$set_of_elements[] = $answer->data->id;

        disconnect(self::$token);
    }


    /**
     *	Check userA cannot see any items of userB
     *
     */

    public function testAsUserAViewAll() {
        self::$token = connect(self::$users['A']['login'], self::$users['A']['password'], self::$token);
        $answer = apiQuickQueryWithToken(self::$url, 'testitemrestricted', 'myindex', array('testtext' => self::$users['A']['comparation_token'] ), self::$token);
        //var_dump($answer);
        $elements_of_userB_accessible_by_userA = false;
        foreach($answer->data->list as $elment) {
            if (in_array($elment->id, self::$set_of_elements)) {
                $elements_of_userB_accessible_by_userA = true;
                break;
            }
        }
        $this->assertEquals(false, $elements_of_userB_accessible_by_userA);
        disconnect(self::$token);
   }


    /**
    *	Check userB can see its 3 creations
    *
    */

    public function testAsUserBViewAll() {
        self::$token = connect(self::$users['B']['login'], self::$users['B']['password'], self::$token);
        $answer = apiQuickQueryWithToken(self::$url, 'testitemrestricted', 'myindex', array('testtext' => self::$users['A']['comparation_token'] ), self::$token);
        // var_dump($answer);
        $one_of_elements_userB_notaccessible_by_himself = false;
        $all_ids = array();
        foreach($answer->data->list as $elment) {
            $all_ids[] = $elment->id;
        }
        foreach(self::$set_of_elements as $element) {
            if (!in_array($element, $all_ids)) {
                $one_of_elements_userB_notaccessible_by_himself = true;
                break;
            }
        }
        $this->assertEquals(false, $one_of_elements_userB_notaccessible_by_himself);
        disconnect(self::$token);
    }


    /**
     *	Check userB removes its 3 creations
     *
     */

    public function testAsUserBRemoveAll() {
        self::$token = connect(self::$users['B']['login'], self::$users['B']['password'], self::$token);
        $answer = apiQuickQueryWithToken(self::$url, 'testitemrestricted', 'myindex', array('testtext' => self::$users['A']['comparation_token'] ), self::$token);
        // var_dump($answer);
        foreach(self::$set_of_elements as $element) {
            $answer = apiQuickQueryWithToken(self::$url, 'testitemrestricted', 'mydelete', array('id'=>$element), self::$token);
            $this->assertEquals(true, $answer->data->deleted);
        }
        disconnect(self::$token);
    }


    protected function tearDown() { }

}
