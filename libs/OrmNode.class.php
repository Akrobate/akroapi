<?php


/**
 *	Classe qui represente un dataNode
 *
 *	@author Artiom FEDOROV
 *
 */


class OrmNode extends DataAdapter {

	
	public static $joins = array();
	// @TODO Time a finaliser (format dentrée et icone up/down

	public $filter;
	
	public $start_limit;
	public $nbr_limit;
	public $total;
	
	
	/**
	 *	@brief	Constructeur de classe
	 *	@details	Initialise certaines valeures
	 */
	 
	public function __construct() {
		$this->start_limit = 0;
		$this->nbr_limit = 10;
		$this->total = 0;	
	}

	
	/**
	 *	@brief	Setteur de filtre
	 *	@details	Pour la gestion de collections de données
	 *	@param	filter	Le filtre a set
	 *	@return this	Pour le chainage
	 */
	 
	public function setFilter($filter) {
		$this->filter = $filter;
		return $this;
	}


	/**
	 *	@brief	Getteur d'objets
	 *	@details	Renvoi toutes les noms des tables 
	 *	@return 	Array	Contenant la liste des modules (depuis les tables, non dossiers)
	 */
	
	public static function getAllObj() {
		return sql::showAllTables();
	}
	

	/**
	 *	Methode de recuperation des datas
	 *
	 *	@brief	Recupere la data depuis la table module	
	 *	@param	module	Le nom du module (nom de la table)
	 *	@param	id		L'id de l'enregistrement a recuperer
	 *	@return	Array	Renvoi l'array de l'enregistrement
	 *
	 */

	public static function getData($module, $id) {
		$query = "SELECT * FROM $module WHERE id = $id";
		sql::query($query);
		$data = sql::allFetchArray();
		return $data[0];		
	}


	/**
	 *	Methode de recherche de datas
	 *
	 *	@brief	Recupere la data depuis la table module selon les fields	
	 *	@param	module	Le nom du module (nom de la table)
	 *	@param	fields	liste des champs et valeurs pour la rechercher
	 *	@return	Array	Renvoi l'array de l'enregistrement
	 *
	 */

	public static function findDataFromFields($module, $fields = array(), $concat = "OR") {
	
		$query = "SELECT * FROM $module WHERE ";
		$i = count($fields);
		foreach($fields as $field => $val) {
			$query .= " " . $field . " = '" . $val . "' ";
			$i--;
			if ($i != 0) {
				$query .= $concat . " ";
			}
		}
		echo($query);
		sql::query($query);
		return sql::allFetchArray();
	}


	/**
	 *	Methode permettant d'ajouter une jointure
	 *	@brief Ajoute une jointure
	 *
	 */
	 
	public static function addJoin($table) {
		self::$joins = $table;
	}


	/**
	 *	Methode de recuperation des datas en mode liste avec jointures 1-n
	 *
	 *	@brief	Recupere les datas depuis la table module avec jointures
	 *	@param	module	Le nom du module (nom de la table)
	 *	@param	listFields	Les champs a recuperer
	 *	@return	Array	Renvoi l'array l'ensemble des datas
	 *
	 */

	public function getAllDataWithJoins($module, $listFields = array()) {
		$content = $this->getAllData($module, $listFields);	
		$joins_data = array();
		foreach($listFields as $jname=>$join) {
			if ($join['type'] == 'join') {
				$join_module = $join['join']['table'];
				$joins_data[$jname] = $this->getJoinData($join_module, $this->getFieldListFromDataSet($content, $jname));
				$this->glueJoinDataToData($content, $joins_data[$jname], $jname);
			}
		}
		return $content;
	}



	/**
	 *	Methode de recuperation des datas en mode liste
	 *
	 *	@brief	Recupere les datas depuis la table module
	 *	@param	module	Le nom du module (nom de la table)
	 *	@param	fields	Les champs a recuperer
	 *	@return	Array	Renvoi l'array l'ensemble des datas
	 *
	 */

	public function getAllData($module, $fields = array()) {
		if (isset($this->filter) && $this->filter != '') {
			$query = "SELECT * FROM $module WHERE " . $this->filter;
		} else {
			$query = "SELECT * FROM $module WHERE 1";		
		}

		sql::query($query);
		$this->total = sql::nbrRows();
		$query .= " LIMIT  " . $this->start_limit . ", " . $this->nbr_limit;
		sql::query($query);
		$data_origin = sql::allFetchArray();
		$data_to = array();
		foreach($data_origin as $data) {
			$tmp = array();			
			foreach ($fields as $fieldname=>$field) {
				$tmp[$fieldname] = $data[$fieldname];
			}		
			$data_to[] = $tmp;
		}
		return $data_to;
	}


	/**
	 *	Methode de recuperation des datas a joindre
	 *
	 *	@brief	Recupere les datas de la jointure
	 *	@param	module	Le nom du module a joindre
	 *	@param	id	Array prends en parametre l'array d'ids dont on a besoin de jointure
	 *	@return	Array	Renvoi l'array l'ensemble des datas de jointure
	 *
	 */
	 
	public static function getJoinData($module, $id = array() ) {
		$query = "SELECT * FROM $module WHERE id IN (";
		$query .= implode(',', $id) ;
		$query .= ");";
		sql::query($query);
		$data = sql::allFetchArray();
		$data2 = array();
		foreach($data as $d) {
			$data2[ $d['id'] ] = $d;
		}
		return $data2;
	}
	
	
	/**
	 *	Methode de recuperation de la liste des champs depuis un dataset
	 *
	 *	@brief	Recupere la liste des clefs de champs de data
	 *	@param	data	Ensemble de données consernée
	 *	@return Array	Renvoi Field list from data set
	 *
	 */	
	
	public static function getFieldListFromDataSet($data, $field) {
		$ret = array();
		foreach($data as $d) {
			$ret[$d[$field]] = $d[$field];
		}
		return $ret;
	}
	
	
	/**
	 *	Methode permettant de rajouter au set de data les join data
	 *	
	 *	@brief Joint les datas jointure sur data
	 *	@param	data	Pointeur vers data
	 *	@param	joindata	Les datas de jointure
	 *	@param	field		champ conserné
	 *	@return data		renvoi les datas enrichies
	 *
	 */
	
	public static function glueJoinDataToData(&$data, $joindata, $field) {
		foreach($data as &$d) {
			if ($d[$field]){
				$d[$field] = $joindata[ $d[$field] ];
			} 
		}
		return $data;
	}

	
	/**
	 *	Methode generique de save de tout module
	 *
	 *	@param	module	Le nom du module a sauvegarder (table de destination)
	 *	@param	fields	Liste de champs a sauvegarder ex: Array('nom','prenom',etc..);
	 *	@param	data	Array contenant les donnés a sauvegarder ex: Array ('nom' => Jean, 'prenom'=>'Pierre')
	 *	@return	Array	Renvoi un array contenant msg qui dit s'il y a eut ajout ou edition
	 *											id representant l'id de l'enregistrement conserné
	 *											query	pour debug la chaine envoyé en mysql	
	 */


	public function upsert($module, $fields, $data) {
	
		$nbr_fields = count($fields);
		$data_string_array = array();
		$fields_string = implode(',',$fields);
		$data_string = "";
		foreach($fields as $field) {
			if (isset($data[$field]) && (!empty($data[$field]))) {
				$data_string_array[$field] = '"'.  sql::escapeString( $data[$field] ) .'"';
			} else {
				$data_string_array[$field] = '""';		
			}	
		}		

		// SI id est set alors il s'agit d'un update			
		if (isset($data['id']) && ($data['id'] != 0)) {
		
			foreach($fields as $field) {
				$data_string .= $field . '= ' .  $data_string_array[$field]  . ',';
			}
			$data_string = substr($data_string, 0, -1);
			$query = 'UPDATE ' . $module . ' SET '. $data_string . ' WHERE id=' . $data['id'];	
			sql::query($query);		
			$response['msg'] = 'EDITED';
			$response['id'] = $data['id'];
			$response['query'] = $query;
			
		} else {
		// ID not set alors nouvelle création
			$data_string = implode(',',$data_string_array);
			$query = 'INSERT INTO ' . $module . ' ('.$fields_string.') VALUES ('. $data_string .');';
			sql::query($query);			
			$lastid = sql::lastId();
			$response['msg'] = 'ADDED';
			$response['id'] = $lastid;
			$response['query'] = $query;

		
		}
		return $response;
	}

}
