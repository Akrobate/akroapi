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
	 *	Methode permettant d'afficher les champs dans le mode d'action désiré
	 *	@brief Methode permetant de réaliser une adaptation entre les dataFields et la vue
	 *	@param	data	Données passées en parametre pour l'affichage
	 *	@param	fieldslist	Liste de champs a render
	 *
	 */

	public static function dataFieldsAdapter($data, $fieldslist, $fieldaction = 'view', $rendered = false, $format = ""){
		$ret = array();
		foreach($data as $field => $value) {
			if (isset($fieldslist[$field])) {
				$type = $fieldslist[$field]['type'];
			
				if (in_array($type, self::$allowedfields)) {
					$typename = ucfirst($type);
					$classname = "Field_".$typename;
					$obj = new $classname();
				} else {
					$obj = new Field_Text();
				}
			
				$obj->setAllFieldsParams($field, $fieldslist[$field]);
				$obj->setValue($value);	
				$obj->setAction($fieldaction);
				
				if (!empty($format)) {
					$obj->setFormat($format);
				}
				
				if ($rendered == 'rendered') {
					$ret[$field] = $obj->renderSTR();
				} else {
					$ret[$field] = $obj;
				}
			}
		}
		return $ret;	
	}
	
	
	/**
	 *	Methode permettant de generer un ensemble de fields vides
	 *	@param	fieldslist	Liste des champs au format d'inclusion modules car types necessaires
	 *	@param	fieldaction	Mode des champs a rendre
	 *	@param	rendered	bool	set le mode de rendu soit rendered soit liste d'objets
	 *	@return	Array	Renvoi soit les elements rendus dans un array soit les objets vers ces elements
	 *	
	 */
	
	public static function dataFieldsAdapterEmpty($fieldslist, $fieldaction = 'view', $rendered = false){
		$ret = array();
		
		foreach($fieldslist as $field => $val) {
		
			$type = $fieldslist[$field]['type'];
			
			if (in_array($type, self::$allowedfields)) {
				$typename = ucfirst($type);
				$classname = "Field_".$typename;
				$obj = new $classname();
			} else {
				$obj = new Field_Text();
			}
			$obj->setAllFieldsParams($field, $fieldslist[$field]);
			$obj->setValue("");	
			$obj->setAction($fieldaction);
	
		
			if ($rendered == 'rendered') {
				$ret[$field] = $obj->renderSTR();
			} else {
				$ret[$field] = $obj;
			}
		}
		return $ret;	
	}	
	
	
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
