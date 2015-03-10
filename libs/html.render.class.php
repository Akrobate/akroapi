<?php

class html {
}

// Ici bientot l'implementation complete de l'extension ressources
class ressources {

	public static $js = array();
	public static $ressources = array();
	
	
	public static function add($r) {
		self::$ressources[] = $r;
	}

	public static function get($r) {
		return self::$ressources;
	}

	// Verifier qu'une ressource n'est incluse qu'une fois	
	public static function addJs($js) {
		self::$js[] = $js;
	}
	
	public static function getJs($js) {
		return self::$js;
	}	
	
}
