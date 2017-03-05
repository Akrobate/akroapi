<?php

/**
 * @brief		Classe users permettant de gerer les utilisateurs et l'authentification
 * @details		Connection, deconnection, gestion de la session, tentatives de connection
 *					Classe qui va effectuer toutes les opérations d'authentification gestion des profils
 *					Gestion de la sessions etc etc
 *
 * @author		Artiom FEDOROV
 * @date	2014
 *
 */
 
 
class session {

	public static $status = 0;
	
	public static $data = array();

	public static function start() {
		self::$status = 1;
		session_start();
		self::up();
	}

	public static function writeclose() {
		self::$status = 0;
		session_write_close();
	}

	public static function commit() {
		if (!self::$status) {
			self::$status = 1;
			session_start();
		}
		$_SESSION = self::$data;
		self::writeclose();
	}

	public static function up() {	
		self::$data = $_SESSION;
	}

}
