<?php

/**
 *
 *
 *	@comande
 *	php phpunit.phar ClassSessionsTest.php
 *
 */


define ("PATH_CURRENT", "./");
include_once(PATH_CURRENT . "api.php");

class ClassSessionsTest extends PHPUnit_Framework_TestCase {

	public static $id = 0;
	public static $sid = 0;
	public static $str_key1 = "Test";
	public static $str_value1 = "montest";


    protected function setUp() {
      // On commence par nettoyer la table des sessions
      //session::removeall();
    }


	public function testReinitSessions() {
		$rep = session::removeall();
		$this->assertEquals(true, $rep);
	}


	/**
	 *	On test la création d'une nouvelle
	 *	session
	 *
	 *	@test	On verifie que sid a 32 carracteres
	 *
	 */

	public function testCreateNewSession() {

		$str_key = self::$str_key1;
		$str_value = self::$str_value1;

		$sid = session::start();
		$this->assertEquals(strlen($sid), 32);

		session::$data['test1'][$str_key] = $str_value;

		session::writeclose($sid);

		self::$sid = $sid;

	}


   	/**
	 *	On Connecte l'utilisateur et on recuper les skills
	 *	users / access
	 *
	 */

     public function testReadSession() {

    	//echo("\n\nTestRead:\n");

    	$str_key = self::$str_key1;
		$str_value = self::$str_value1;

    	$sid = session::start(self::$sid);

		//print_r(session::$data);

		$this->assertEquals($sid, self::$sid);

		$this->assertEquals( session::$data['test1'][$str_key] , $str_value);

    }



   	/**
	 *	On detruit une session
	 *
	 *
	 */

     public function testDestroySession() {

    	//echo("\n\nSecond one:\n");
    	session::start(self::$sid);
	    $this->assertEquals( session::$data['test1'][self::$str_key1] , self::$str_value1);
    	session::destroy(self::$sid);
    	$this->assertEquals(false, session::start(self::$sid));
    }




   	/**
	 *	Test de session grande taille
	 *
	 *
	 */

     public function testLargeDataSession() {

    	//echo("\n\nSecond one:\n");
    	self::$sid = session::start();

    	$nbrparams = 800;

    	for($i = 0; $i < $nbrparams; $i++) {
    		$params['param' . $i] = 1;
    	}

    	$data = DataNode::peopleTable("test", $params);
    	$nb = strlen(serialize($data));




		// 21581
    	while($nb > 21100) {
    		array_pop($data);
    		$nb = strlen(serialize( $data ) );
    	}

		//echo("Nombre de datas: " . count($data) . "\n\n");

		session::$data = $data;

		// On save les datas
		session::writeclose(self::$sid);

		// Test: le data de session est bien vide
		$this->assertEquals(0, count(session::$data));

		// On restart la session
		session::start(self::$sid);

		// Test on verifie que dans la session on a bien le nombre de datas
		$this->assertEquals(count($data), count(session::$data));

		// On destroy la session
    	session::destroy(self::$sid);

		// Test: le data de session est bien vide
		$this->assertEquals(0, count(session::$data));

		// On verifie que la session a bien expiré
		$this->assertEquals(session::start(self::$sid), false);

    }



   	/**
	 *	Test de session grande taille
	 *
	 *
	 *	perf pour 1000: 1min45, 1min43
	 *
	 *
	 */

     public function testSanitize() {

   		$testnbr = 200;

   		// start 1000 different sessions
   		for($i = 0; $i < $testnbr; $i++) {
	   		session::start();
   		}

   		sleep(2);
	    session::$duration = 1;
		$nbr = session::sanitize();
     	//echo("------------ " . $nbr . " --------- \n");
     	$this->assertEquals($testnbr, $nbr);
     }



    protected function tearDown() {


    }


}
