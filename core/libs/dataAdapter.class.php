<?php

/**
 *	Classe d'adaptation des datas en leur présentation finale
 *		legerement inspiré du principe des listAdapter sous Androids
 *
 *	@author		Artiom FEDOROV
 *	@date		20/12/2014
 */

class DataAdapter {

	// Liste des champs autorisés a l'affichage

	public static $allowedfields = array('text', 'join', 'largetext', 'photourl', 'date');


	/**
	 *	Methode permettant de recuperer la liste des champs
	 *	@param	module	Nom du module pour la recuperation de la liste des champs
	 *	@return	Array	Renvoi l'array déclaré dans l'include
	 *
	 */

	public static function getFieldsFor($module) {
		if (!empty($module)){
			if (file_exists(PATH_MODULES . $module . "/fields.php")) {
				include(PATH_MODULES . $module . "/fields.php");
			} else if (file_exists(PATH_CORE_INTERNAL_MODULES . $module . "/fields.php")) {
				include(PATH_CORE_INTERNAL_MODULES . $module . "/fields.php");
			}
			$fields = self::enrichFieldsWithTypes($fields);
			return $fields;
		}
	}


	/**
	 *	Methode permettant d'enrichier la liste des champs aveec les types
	 *	@param	module	Nom du module pour la recuperation de la liste des champs
	 *	@return	Array	Renvoi l'array déclaré dans l'include
	 *
	 */

	public static function enrichFieldsWithTypes($fields) {

		$retFields = array();
		foreach ($fields as $fieldname => $fields) {
			$retFields[$fieldname] = $fields;
			if (! isset ($retFields[$fieldname]['typeSQL'])) {
				$retFields[$fieldname]['typeSQL'] = self::getSqlTypeFromStdType($fields['type']);
			}
		}
		return $retFields;
	}

	/**
	 *	Renvoie le typeSQL en fonction de types
	 *  array('text', 'join', 'largetext', 'photourl', 'date');
	 *
	 *
	 *	sessionid
	 *
	 */

	public static function getSqlTypeFromStdType($type) {
		$resp = "";
		switch ($type) {
			case "textid64":
				$resp = "VARCHAR(64)";
				break;
			case "bigvarchar":
				$resp = "VARCHAR(21581)";
				break;
			case "text":
				$resp = "VARCHAR(255)";
				break;
			case "largetext":
				$resp = "TEXT";
				break;
			case "smalltext":
				$resp = "VARCHAR(25)";
				break;
			case "photourl":
				$resp = "VARCHAR(255)";
				break;
			case "date":
				$resp = "DATE";
				break;
			case "datetime":
				$resp = "DATETIME";
				break;
			case "coords":
				$resp = "DECIMAL(17,14)";
				break;
			case "altitude":
				$resp = "DECIMAL(9,5)";
				break;
			case "androidid":
				$resp = "VARCHAR(64)";
				break;
			case "int":
				$resp = "INT(11)";
				break;
			case "price":
				$resp = "DECIMAL(10,2)";
				break;
			case "decimal5-2":
				$resp = "DECIMAL(5,2)";
				break;
			case "join":
				$resp = "INT(11)";
				break;
		}
		return $resp;
	}


	/**
	 *	@brief	Renvoi la liste des clefs d'un module
	 *	@details	Renvoi la liste simple des champs d'un module
	 *
	 *	@param	module	Nom du module a interroger
	 *	@return Arra	Tableau contenant la liste des champs du module
	 *				Ex: array('nom','prenom', etc);
	 =
	 */

	public static function getFields($module) {
		$fields = self::getFieldsFor($module);
		$allFields = array_keys($fields);
		return $allFields;
	}


	/**
	 *	Methode permettant de recuperer le label pour un champ
	 *	@param	field
	 *	@return	String
	 *
	 */

	public static function getFieldLabel($field, $module) {
		if (!empty($module)){
			$fields = self::getFieldsFor($module);
			return $fields[$field]['label'];
		}
		return "";
	}
}
