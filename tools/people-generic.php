<?php

/**
 *	Script de build du CRM
 *	
 *	@brief		Script permettant de peupler toutes les tables
 *	@details	Peuple toutes les tables avec du lorem ipsum
 *				Crée les jointures factices aussi
 *
 *	@usage		clear;php people-generic.php --people
 *	
 *	@author 	Artiom FEDOROV
 */
 
 
// On crée la surcharge
define('PATH_CURRENT', "../");
require_once("../api.php");

error_reporting(15);

// On set le debug SQL a true
sql::display(1);
$dirs = scandir(PATH_MODULES);
error_reporting(15);
$tree = array();
sql::display(1);
$nbr_items_per_table = 20;
$dirs =  ModuleManager::getAllModules();
$contactsrandomapi = true;
  
if (in_array("--people", $argv)) {

	// Peuplement de tous les modules Sauf contacts
	foreach($dirs as $dir) {
		if($dir != 'contacts') {
			if (sql::tableExists($dir)) {
				unset($fields);
				$toinclude = PATH_MODULES . $dir . PATH_SEP ."fields.php";
				include($toinclude);
			
				for($j = 0; $j < $nbr_items_per_table; $j++) {
					$data = DataNode::peopleTable($dir, $fields);
					$obj = new OrmNode();
					$allFields = array_keys($fields);
					$obj->upsert($dir, $allFields, $data);				
				}
			}
		}
	}
	
	/**
	 *	Partie du Script de build des jointures du CRM
	 *	
	 *	@brief		Script permettant de les jointures du CRM
	 *	@details	Peuple toutes les tables avec les jointures du CRM
	 *	
	 */
	 
	foreach($dirs as $dir) {	
		if($dir != 'contacts') {
			$fields = OrmNode::getFieldsFor($dir);
			foreach ($fields as $name => $field) {
				if ($field['type'] == 'join') {			
					$joinmodule = $field['join']['table'];
					$orm = new OrmNode();
					$alldata = $orm->getAllData($joinmodule, array('id'=>'id'));
				
				
					foreach($alldata as $d) {
						$randjoin = rand(1, $nbr_items_per_table);
						$fields1 = OrmNode::getFieldsFor($dir);
						$data = array();
						$data[$name] = $randjoin;
						$allFields = array();
						$allFields[] = $name;
						$allFields[] = 'id';
						$data['id'] = $d['id'];
						$rez = $orm->upsert($dir, $allFields, $data);
					}
				}
			}
		}
	}

}

