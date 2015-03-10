<?php

/**
 *	Script de build du CRM
 *	
 *	@brief		Script permettant de construire les tables des modules internes, 
 *	@details	Les modules internes definis dans core sont construits par cette commande	
 *
 *	@usage		clear;php internal-build.php --internalcreate
 *	
 *	@author 	Artiom FEDOROV
 */
 
 
// On crée la surcharge
define('PATH_CURRENT', "../");
require_once("../api.php");

error_reporting(15);

// On set le debug SQL a true
sql::display(1);

if (in_array("--internalcreate", $argv)) {
	$dirs =  ModuleManager::getAllInternalModules();
	foreach($dirs as $dir) {
		if (sql::tableExists($dir)) {
			sql::removeTable($dir);
		}
			
		unset($fields);
		$toinclude = PATH_CORE_INTERNAL_MODULES . $dir . PATH_SEP ."fields.php";
		include($toinclude);
		sql::createTable($dir, $fields);		
	}
}
