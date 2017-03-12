<?php


/**
 *	Classe qui represente un dataNode
 *
 *	@author Artiom FEDOROV
 *
 */


class UserOrmNode extends OrmNode {

	public $disable_limits = false;
    public $owner_user_id;


    public function setOwnerUserId($owner_user_id) {
        $this->owner_user_id = $owner_user_id;
    }


    public function getOwnerUserId() {
        return $this->owner_user_id;
    }


	/**
	 *	@brief	Constructeur de classe
	 *	@details	Initialise certaines valeures
	 */

	public function __construct($owner_user_id) {
        $this->owner_user_id = $owner_user_id;
        parent::__construct();
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

	public function getData($module, $id) {
		$query = "SELECT * FROM $module WHERE id = $id AND owner_user_id = " . $this->getOwnerUserId();
		sql::query($query);
		$data = sql::allFetchAssoc();
        if (count($data) == 1) {
		    return $data[0];
        } else {
            return null;
        }
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

		$query = "SELECT * FROM $module WHERE owner_user_id = " . $this->getOwnerUserId() . " AND (";
		$i = count($fields);
		foreach($fields as $field => $val) {
			$query .= " " . $field . " = '" . $val . "' ";
			$i--;
			if ($i != 0) {
				$query .= $concat . " ";
			}
		}
        $query .= ")";
		echo($query);
		sql::query($query);
		return sql::allFetchArray();
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
			$query = "SELECT * FROM $module WHERE " . $this->filter . " AND owner_user_id = " . $this->getOwnerUserId();
		} else {
			$query = "SELECT * FROM $module WHERE owner_user_id = " . $this->getOwnerUserId();
		}

		sql::query($query);
		$this->total = sql::nbrRows();

		if ($this->disable_limits == false) {
			$query .= " LIMIT  " . $this->start_limit . ", " . $this->nbr_limit;
		}
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
        $data['owner_user_id'] = $this->getOwnerUserId();
		$rez = parent::upsert($module, $fields, $data);
        return $rez;
	}

}
