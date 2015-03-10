<?php

/**
 *	Classe qui s'occupe de la recupération des paramatetres
 *	@author	Artiom FEDOROV
 */

class request {

	public static function get($str) {
		if (isset($_GET[$str])) {
			return $_GET[$str];
		} elseif (isset($_POST[$str])) {
			return $_POST[$str];
		} else {
			return null;
		}
	}
	
	
	public static function getPostRequest($str) {
		if (isset($_POST[$str])) {
			return json_decode($_POST[$str]);
		} else {
			return null;
		}
	}
	
	

}
