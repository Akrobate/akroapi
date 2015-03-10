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
 
 
class users {

	// Variable permettant de stocker l'état d'un utilisateur
	private static $connected = null;
	
	// Variable contenant toutes les données utilisateur
	public static $me = array();
	
	// Variable membre contenant le profil de l'utilisateur	
	public static $profile = array();
	
	
	/**
	 * @brief		Verifie si l'id user est set dans la session
	 * @return    bool		Renvoir true si session set, et false sinon
	 *
	 */
	
	public static function issetId() {
		return isset($_SESSION['user']['id']);
	}
	
	
	/**
	 * @brief		Recupere le user id de l'utilisateur courant
	 * @details		Récupère en session  (actuellement connecté)
	 * @return    int		Renvoi l'id de l'utilisateur courant
	 *
	 */
	
	public static function getId() {
		return $_SESSION['user']['id'];
	}
	
	
	/**
	 * @brief		Connecte l'utilisateur
	 * @details		Méthode de conncetion verifiant l'authentification
	 *				Cette méthode verifie l'utilisateur en base
	 * @param	login		Nom d'utilisateur 
	 * @param	pw			Mot de passe de l'utilsateur
	 * @return	bool		Renvoi true si utilisateur connecté, false sinon
	 *
	 */
	 
	public static function connect($login, $pw) {
		if( (ADMIN_LOGIN == $login) && (ADMIN_PASSWORD == $pw)) {		
			// Si l'utilisateur est admin alors on charge sa conf de manière artificielle (avec des fichiers)
			self::$connected = true;
			$_SESSION['user']['connected'] = true;
			return true;
		} else {
			// verification si l'utilisateur existe en base.
			sql::query("SELECT * FROM users WHERE login='".$login."' AND password='".$pw."'");
			if ($user = sql::fetchArray()) {
				self::$connected = true;
				self::$me = $user;
				$_SESSION['user'] = self::$me;
				$_SESSION['user']['connected'] = true;
				self::getProfile();
				return true;
			} else {
				self::$connected = false;
				unset($_SESSION['user']);
				unset($_SESSION['profile']);
				return false;	
			}
		}
	}
	

	/**
	 * @brief		Renvoi l'utilisateur courant
	 * @details		Charge l'utilisateur courant depuis la session et le renvoi
	 * @return	Array	Renvoi un tableau contenant les informations utilisateur
	 *
	 */
	 		
	public static function getMe() {
		if (isset($_SESSION['user'])) {
			self::$me = $_SESSION['user'];
		}
		return self::$me;
	}
	
	
	/**
	 * @brief		Renvoi le profil de l'utilisateur courant
	 * @details		Récupère le profil depuis la session ou sinon recharge le profil
	 * @return	Array	Renvoi un tableau contenant les informations du profil de l'utilisateur
	 *
	 */
	
	public static function getProfile() {
	
		if (isset($_SESSION['profile'])) {
			self::$profile = $_SESSION['profile'];
		} else {
			self::loadProfile();
		}
		return self::$profile;
	}


	/**
	 * @brief		Charge le profil pour l'utilisateur
	 * @details		Récupère le profil depuis un fichier pour l'admin et depuis la base pour un utilisateur quelconque
	 * @return	Array	Renvoi un tableau contenant les informations du profil de l'utilisateur, false si pas de profil
	 *
	 */
	 
	public static function loadProfile() {
		
		if(self::$connected == true) {
			if( (self::$me['login'] == ADMIN_LOGIN)) {		
				// Include profile prochainement ici
			} else {
				sql::query("SELECT * FROM profiles WHERE id = " . self::$me['id_profil'] );
				if ($profile = sql::fetchArray()) {			
					eval($profile['view']);
					self::$profile['view'] = $view;
					$_SESSION['profile'] = self::$profile;
				} else {
					return false;
				}
			}
		}
	}	
		
	
	/**
	 * @brief		Methode de déconnection
	 * @details		Méthode de déconnection qui unset l'ensemble des données de la session, *
	 * @return	bool	Renvoi true si bien déconnecté
	 *
	 */

	public static function logout() {
		unset($_SESSION['user']);
		unset($_SESSION['profile']);
		self::$connected = false;
		return true;
	}


	/**
	 * @brief		Méthode permettant de verifier la connection
	 * @details		Méthode qui verifie si l'utilisateur est actuellement connecté
	 *				Sinon tente de se connecter via la méthode tryToConnect
	 *
	 * @return	bool	Renvoi true si bien connecté et false sinon
	 *
	 */

	public static function isConnected() {
		if (@$_SESSION['user']['connected'] == true) {
			self::$connected = true;
			return true;
		} else {
			self::$connected = false;
			return self::tryToConnect();
		}
	}
	
	
	/**
	 * @brief		Tente de connecter l'utilisateur
	 * @details		Méthode permettant de tenter une connection via paramétres dans url
	 *					login et password dans l'url
	 * @return	bool	Renvoi true si bien connecté et false sinon
	 */
	
	public static function tryToConnect() {
		$login = request::get('login');
		$password = request::get('password');
		if (($login != "") && ( $password != "" )) {
			if (users::connect($login, $password)) {
				return true;	
			}
		}	
		return false;
	}
	
}

