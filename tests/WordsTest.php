<?php

include("tests/functions.php");

class WordsTest extends PHPUnit_Framework_TestCase {


    protected function setUp() {
      
    }


    public function testOne() {
    
    	$url = "http://localhost/dropaword/";
	    $data = array("name" => "Hagrid", "age" => "36");
		$query = json_encode($data);
    	echo(curlPostQuery($url, $query));
    }


    public function testTwo() {
		$url = "http://localhost/dropaword/";
	    $data = array("name" => "Hagrid", "age" => "36");
		$query = json_encode($data);
    	echo(curlPostQuery2($url, $query));
    }


    protected function tearDown() {


    }
}

