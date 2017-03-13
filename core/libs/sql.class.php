<?php

/**
 * @brief		Classe sql permettant de gerer toutes les interaction de base de données
 * @details		surcharge de toutes les méthodes d'acces a la base de données
 *
 * @author		Artiom FEDOROV
 */

class sql extends sqlAdvanced{

	private static $connect_handler = null;
	private static $query_result;
	public  static $display = 0; // variable pour le debug


	/**
	 * @brief		Méthode de connection a la base de données
	 * @details		Se connecte a la base de données selon les constantes
	 *				DB_HOST, DB_USER, DB_PASSWORD
	 *				Le handler est renvoyé et stocké au niveau du singleton
	 * @return	handler		Renvoi le handler de la connection
	 */

	public static function connect() {
		$connect_handler = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
		mysqli_select_db($connect_handler, DB_NAME);
		self::$connect_handler = $connect_handler;
		self::query ('SET CHARACTER SET '. DB_CHARSET);

		return self::$connect_handler;
	}


	/**
	 * @brief		Méthode d'execution de requetes
	 * @details		Execute la requette
	 *				DB_HOST, DB_USER, DB_PASSWORD
	 *				Le pointeur de la requete est renvoyé et stocké au niveau du singleton
	 * @return	query_result	Renvoie le resultat de la requette a fetcher
	 */

	public static function query($query, $connect_handler = NULL) {
		if ($connect_handler == null) {
			if (self::$connect_handler == null) {
				self::connect();
			}
			self::$query_result = mysqli_query(self::$connect_handler, $query);
		} else {
			self::$query_result = mysqli_query($connect_handler, $query);
		}
		return self::$query_result;
	}

	/**
	 * @brief		Méthode d'execution de requetes
	 * @details		Execute la requette
	 *				DB_HOST, DB_USER, DB_PASSWORD
	 *				Le pointeur de la requete est renvoyé et stocké au niveau du singleton
	 * @return	query_result	Renvoie le resultat de la requette a fetcher

	 */

	public static function multiQuery($query, $connect_handler = NULL) {
		if ($connect_handler == null) {
			if (self::$connect_handler == null) {
				self::connect();
			}
			self::$query_result = mysqli_multi_query(self::$connect_handler, $query);
		} else {
			self::$query_result = mysqli_multi_query($connect_handler, $query);
		}
		return self::$query_result;
	}


	/**
	 * @brief		Methode qui renvoie tous les resultats de la requete
	 * @details		Fetch l'ensemble de la requete avec la méthode fetch_array
	 * @return	Array	Renvoi tous les résultats de la requete
	 */

	public static function allFetchArray() {
		$data = array();
		while ($return = @mysqli_fetch_array(self::$query_result)) {
			$data[] = $return;
		}
		return $data;
	}


	/**
	 * @brief		Methode qui renvoie tous les resultats de la requete
	 * @details		Fetch l'ensemble de la requete avec la méthode fetch_array
	 * @return	Array	Renvoi tous les résultats de la requete
	 */

	public static function allFetchAssoc() {
		$data = array();
		while ($return = self::fetchAssoc()) {
			$data[] = $return;
		}
		return $data;
	}



	/**
	 * @brief		Methode qui renvoie un resultat de la requete
	 * @details		Fetch de la requete avec la méthode fetch_array
	 * @return	Array	Renvoi le resultat courant de la requete
	 */

	public static function fetchArray() {
		return mysqli_fetch_array(self::$query_result);
	}

	/**
	 * @brief		Methode qui renvoie un resultat de la requete

	 * @details		Fetch de la requete avec la méthode fetch_array
	 * @return	Array	Renvoi le resultat courant de la requete
	 */

	public static function fetchAssoc() {
		return mysqli_fetch_assoc(self::$query_result);
	}


	/**
	 * @brief		Methode qui renvoie le nombre de résultats
	 * @details		nombre de resultats de la requete
	 * @return	int	Renvoi nombre de resultats
	 */

	public static function nbrRows() {
		return @mysqli_num_rows(self::$query_result);
	}

	/**
	 * @brief		Methode qui renvoie le nombre de résultats
	 * @details		nombre de resultats de la requete
	 * @return	int	Renvoi nombre de resultats
	 */

	public static function nbrAffectedRows() {
		return @mysqli_affected_rows(self::$connect_handler);
	}


	/**
	 * @brief		Methode qui renvoie l'id du dernier element inseré
	 * @details		identifiant du dernier enregistrement crée
	 * @return	int	Renvoi l'id
	 */

	public static function lastId() {
		return mysqli_insert_id(self::$connect_handler) ;
	}


	/**
	 * @brief		Methode qui echape les chaines de carractere
	 * @details		Pour eviter l'injection sql toutes les données d'UI doivent etre echapés
	 * @param	string	Chaine de carractere a echapper
	 * @return	string	Chaine echappée
	 *
	 */

	public static function escapeString($string) {
		if (self::$connect_handler == null) {
			self::connect();
		}
		return mysqli_real_escape_string(self::$connect_handler, $string);
	}


	/**
	 * @brief		Methode qui echape les chaines de carractere d'un Array
	 * @details		Pour eviter l'injection sql toutes les données d'UI doivent etre echapés
	 * @param	Array	Tableau contenant des chaines de carractere a echapper
	 * @return	Array	Tableau contenant les chaines echappées
	 *
	 */

	public static function escapeArray($arr) {
		foreach($arr as $key => $val) {
			if (is_string($val)) {
				$arr[$key] = self::escapeString($val);
			}
		}
		return $arr;
	}


	/**
	 * @brief		Permet d'afficher le debug
	 * @details		Peut s'averer utile pour les methodes de build
	 * @param	var	active desactive
 	 *
	 */

	public static function display($var) {
		self::$display = $var;
	}


	public static function errorNo() {
		return mysqli_errno(self::$connect_handler);
	}

	public static function error() {
		return mysqli_errno(self::$connect_handler)." : ".mysqli_error(self::$connect_handler);
	}




}
