<?php

/**
 *	Script de build du CRM
 *	
 *	@brief		Script permettant de builder toutes les tables dans modules
 *	@details	Script permettant de builder toutes les tables dans modules
 *				Sauf les internal tables
 *
 *	@usage		clear;php build.php --create
 *	
 *	@author 	Artiom FEDOROV
 */
 
define('PATH_CURRENT', "../");
require_once("../api.php");
$dirs = scandir(PATH_MODULES);
error_reporting(15);
$tree = array();
sql::display(1);
$nbr_items_per_table = 20;
$dirs =  ModuleManager::getAllModules();
$contactsrandomapi = true;



if (in_array("--create", $argv)) {
	foreach($dirs as $dir) {
		if (sql::tableExists($dir)) {
			sql::removeTable($dir);
		}		
		unset($fields);
		$toinclude = PATH_MODULES . $dir . PATH_SEP ."fields.php";
		include($toinclude);
		$tree[$dir] = $fields;
		sql::createTable($dir, $fields);	
		echo("ok\n")	;
	}
}


