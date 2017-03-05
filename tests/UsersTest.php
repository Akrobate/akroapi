<?php

include_once("functions.php");

class UsersTest extends PHPUnit_Framework_TestCase {

	public static $url = API_URL;
	public static $token = null;


    protected function setUp() {
      
    }


	/**
	 *	Methode de test d'acces publique a la page
	 *	users / access
	 */

    public function testGetAccesses() {
		$answer = apiQuickQueryWithToken(self::$url, 'users', 'access', array(), self::$token);	
		self::$token = $answer->token;
		$exists = false;
		if ($answer->errorId != 404) {		
			foreach(@$answer->data->acl as $p) {
				if (($p->module == 'users') && ($p->action == 'access')) {
					$exists = true;
				}
			}
		}
		$this->assertEquals($exists, true);
    }
    
    
    public function testRefusedAccess() {
		$answer = apiQuickQueryWithToken(self::$url, 'users', 'accessunexists', array(), self::$token);
		$authorized = true;	
		if ($answer->errorId == 404) {
			$authorized = false;
		} 
		$this->assertEquals($authorized, false);				
    }    
    



    public function testLoginFalse() {
		$params['login'] = "blabla";
    	$params['password'] = "test";
		$answer = apiQuickQueryWithToken(self::$url, 'users', 'login', $params, self::$token);				
		if ($answer->errorId == 200) {		
			$this->assertEquals($answer->data->status, 'invalid');
		}
    }



    public function testLoginConnected() {
		$params['login'] = "admin";
    	$params['password'] = "987";
		$answer = apiQuickQueryWithToken(self::$url, 'users', 'login', $params, self::$token);				
		$this->assertEquals(self::$token, $answer->token);		
		self::$token = $answer->token;
		if ($answer->errorId == 200) {		
			$this->assertEquals($answer->data->status, 'connected');
		}
    }
 
    
    public function testGetAccessesAfterLogin() {
		$answer = apiQuickQueryWithToken(self::$url, 'users', 'access', array(), self::$token, false);		
		$this->assertEquals('yes', $answer->data->connected);
    }
    
    
    public function testLogout() {
		$answer = apiQuickQueryWithToken(self::$url, 'users', 'logout', array(), self::$token);	
		if ($answer->errorId == 200) {		
			$this->assertEquals($answer->data->status, 'logout');								
		}
    }
    
    
    public function testAccessAfterLogout() {
    	$answer = apiQuickQueryWithToken(self::$url, 'users', 'access', array(), self::$token, false);		
		$allpublic = true;
		foreach ($answer->data->acl as $acl) {
			if ($acl->access != 'public') {
				$allpublic = false;
			}
		}
		$this->assertEquals($allpublic, true);
    }


    protected function tearDown() {

    }
}
