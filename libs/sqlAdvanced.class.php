<?php

/**
 * @brief		Classe sqlAdvanced permettant de gerer toutes les interractions de tables
 * @details		Permet de gerer les interraction en mysql avec les tables
 *				
 * @author		Artiom FEDOROV
 */

class sqlAdvanced {


	/**
	 * @brief		Affiche toutes les tables
	 * @details		Affiche les tables 
	 * @return	Array contenant l'ensemble des tables
	 */
	 
	public static function showAllTables() {
		$query="SHOW TABLES";
		sql::query($query);
		return sql::allFetchArray();	
	}


	/**
	 * @brief		Methode qui permet la creation d'une table
	 * @details		
	 * @param	name	Nom de la table a creer
	 * @param	params	Array contenant la description a suivre pour la creation de la table
	 */

	public static function createTable($name, $params = array()) {
	
		if (!empty($name)) {
			$query = "CREATE TABLE IF NOT EXISTS ". $name ." (id mediumint(9) NOT NULL AUTO_INCREMENT, ";
			  
			 foreach( $params as $fieldname => $val ) {
			 
			 	$sqltype = DataAdapter::getSqlTypeFromStdType($val['type']);
			 	 
			 	if ($val['type'] == 'join') {
					 $query .= " $fieldname " . $sqltype . " NOT NULL, ";
			 	} else if ($val['type'] == 'date') {	 
				 	$query .= " $fieldname " . $sqltype . " NOT NULL, ";
				 } else if ($val['type'] == 'largetext') {	 
				 	$query .= " $fieldname " . $sqltype . " NOT NULL, ";
				 } else if ($val['type'] == 'text') {	 
				 	$query .= " $fieldname " . $sqltype . " NOT NULL, ";
				 } else {
				 	$query .= " $fieldname " . $sqltype . " NOT NULL, ";
				 }
			 }
			  
			 $query .= " PRIMARY KEY (id)) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ; ";
			 sql::query($query);

			if (sql::$display) {
				echo("\n Table de travail : ". $name  ." crée \n\n");
			}
		}	
	}


	/**
	 * @brief		Methode qui supprime une table
	 * @details		Supprime la table name
	 * @param	name	Nom de la table a supprimer
	 */

	public static function removeTable($name) {
		if (!empty($name)) {
			$query = "DROP TABLE IF EXISTS ". $name ." ;";
			sql::query($query);
			if (sql::$display) {
				echo("\n Table de travail : ". $name  ." Supprimée \n\n");
			}
		}
	}
	
	
	/**
	 * @brief		Verifie l'existance d'une table
	 * @details		Verifie si la table table exists renvoi true si oui else sinon
	 * @param	table	nom de la table a verifier
 	 * @return	bool	Renvoi true si table existe false sinon
 	 *
	 */
	
	public static function tableExists($table) {	
		if (!empty($table)) {
			$query = " SHOW TABLES FROM " . DB_NAME . " LIKE '".$table."' ";
			sql::query($query);
			$nb = sql::nbrRows();
			if ($nb > 0) {
				return true;
			} else {
				return false;
			}
		}
	}


	/**
	 * @brief		Methode qui ajoute un champ
	 * @details		Ajoute un champ fieldname a la table name de type sql type
	 * @param	table	Nom de la table a alterer
	 * @param	fieldname	Nom du champt a ajouter
 	 * @param	type	type SQL du champ
 	 *
	 */

	public static function addField($table, $fieldname, $type) {	
		if (!empty($table)) {
			$query = " ALTER TABLE $table ADD $fieldname $type ";
			sql::query($query);
			if (self::$display) {
				echo("\n Champ $fieldname Ajouté : dans la table $table \n\n");
			}
		}
	}
}

