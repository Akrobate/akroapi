<?php

/**
 *	Classe qui s'occupe de la recupération des paramatetres
 *	@author	Artiom FEDOROV
 */

class request {


	/**
	 *	Methode generique de recuperation de parametres
	 *	@details	Récupere en premier lieu le get puis post sinon null
	 *	@param		Prent en parametre le nom du parametre a récuperer
	 *	@return 	String correspondant a la valeur demandé par str ou null sinon
	 *
	 */

	public static function get($str) {
		if (isset($_GET[$str])) {
			return $_GET[$str];
		} elseif (isset($_POST[$str])) {
			return $_POST[$str];
		} else {
			return null;
		}
	}
	
	
	
	/**
	 *	Methode generique de recuperation de parametres POST
	 *	@details	Récupere parametre en post sinon null
	 *	@param		Prent en parametre le nom du parametre a récuperer
	 *	@return 	String correspondant a la valeur demandé par str ou null sinon
	 *
	 */
	 
	public static function getPostRequest($str) {
		if (isset($_POST[$str])) {
			return json_decode($_POST[$str]);
		} else {
			return null;
		}
	}
	
	
	/**
	 *	Methode permettant de lire la requete JSON en post
	 *	@details	Utilise le process file_get_content php://input
	 *	@return Array Renvoi le tableau du JSON decodé	
	 *	
	 */

	public static function getPostJSON() {
	
		$postJson = file_get_contents("php://input");	
		if (!empty($postJson)) {
			return json_decode($postJson);
		} else {
			return null;
		}
	}	

}
