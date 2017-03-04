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

	// Durée de la session en secondes
	public static $duration = 600;

	public static $status = 0;

	public static $id = 0;

	public static $sid = 0;
	
	public static $data = array();

	public static $error = "";

	/**
	 *	Methode qui start une fonction
	 *	si sid est nul alors nouvelle session
	 *
	 */

	public static function start($sid = null) {

		if (!is_null($sid)) {
			// recherche
			sql::query("SELECT * FROM sessions WHERE sessionid = '" . $sid . "'");
			if (sql::errorNo()) {
				echo(sql::error());
			}
			
			$nbr = sql::nbrRows();
	
			if ($nbr == 1) {
				$alldatas = sql::fetchAssoc();
				self::$data = unserialize($alldatas['data']);
				self::$status = 1;
				return $sid;
			} elseif ($nbr > 1) {
				self::$error = "cant start error";
				return false;
			} else {
			
			
				self::$error = "cant start session expired, please reconnect";
				return null;
				
				
				
			}
		} else {
			// On genere une clef aléatoire
			$strid = rand(1, 100000) . " " . rand(1,100000);
			
			$sid = md5($strid);
			
			// On verifie que la cles est bien unique
			sql::query("SELECT * FROM sessions WHERE sessionid = '" . $sid . "'");
			$nbr = sql::nbrRows();
			
			if ($nbr == 0) {
				$timestamp = time();
				sql::query("INSERT INTO sessions (sessionid, timestamp, created, updated)
								 VALUES ('" . $sid . "', '" . $timestamp . "', NOW() , NOW() );");
				if (sql::errorNo()) {
					echo(sql::error());
				}
			}

			self::$status = 1;
			self::$id = sql::lastId();
			return $sid;
			
		}
		
		
	}


	/**
	 *	Methode de suppression d'une session
	 *	@param	$sid	ID de la session
	 *	@return bool	true
	 */

	public static function destroy($sid) {

		// On verifie l'existance
		sql::query("SELECT * FROM sessions WHERE sessionid = '" . $sid . "'");
		$nbr = sql::nbrRows();
		
		if ($nbr != 0) {
			$alldatas = sql::fetchAssoc();
			$id = $alldatas['id'];
			sql::query("DELETE FROM sessions WHERE id = $id ");
		}
		self::close();
		sleep(2);
		return true;
	}
	
	
	/**
	 *	Sauvegarde la sessions en cours
	 *	et ferme la session
	 *
	 */
	
	public static function writeclose($sid = null) {
		self::write($sid);
		self::close();
		return true;
	}
	
		
	/**
	 *	Sauvegarde la sessions en cours
	 *	
	 *
	 */
	
	public static function write($sid = null) {

		if (!is_null($sid)) {
			$str = serialize(self::$data);
			$timestamp = time();
			sql::query("UPDATE sessions SET data = '" . sql::escapeString($str) . "', 
							timestamp = $timestamp , 
							updated = NOW() 
								WHERE sessionid = '" . $sid . "'");
			if (sql::errorNo()) {
				echo(sql::error());
			}
		}
		return true;			
	
	}


	/**
	 *	Methode de fermeture de fonctio
	 *	
	 *	@brief	remet la classe a son état initial
	 *
	 */

	public static function close() {
		self::$status = 0;
		self::$id = 0;
		self::$sid = 0;
		self::$data = array();
		self::$error = "";	
		return true;
	}
	
	
	
	/**
	 *	Methode permettant de mettre a jour la table
	 *	en supprimant les sessions expirées
	 *	
	 *	@brief	
	 *
	 */

	public static function sanitize() {
		
		$searchMinDuration = time() - self::$duration;

		sql::query("SELECT * FROM sessions WHERE timestamp < $searchMinDuration");
		$nbr = sql::nbrRows();

		if ($nbr > 0) {
			$data = sql::allFetchAssoc();
			$sids = array();
			foreach($data as $session) {
				$sids[] = $session['id'];
			}

			$sidsstr = implode(",", $sids);
			sql::query("DELETE FROM sessions WHERE id IN ({$sidsstr})");
		}

		return $nbr;
	}

	/**
	 *	Methode permettant de mettre a zero la table
	 *	en supprimant toutes les sessions 
	 *	
	 *	@brief	
	 *
	 */

	public static function removeall() {
		sql::query("DELETE FROM sessions WHERE 1");
		return true;
	}


}
