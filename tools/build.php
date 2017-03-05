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
		unset($table);		
		$toinclude = PATH_MODULES . $dir . PATH_SEP ."fields.php";
		include($toinclude);
		$tree[$dir] = $fields;

		//	Creation des tables		
		// Si parametres de table ont été précisés
		if (isset($table)) {
			sql::createTable($dir, $fields, $table);
		} else { 
			sql::createTable($dir, $fields);
		}
	
		echo(" creation: ok -- \n");

		//	Initialise la base avec les vrais index
		
		if (isset($indexqueries)) {
			foreach($indexqueries as $indexQuery) {
				sql::query($indexQuery);

				if (sql::errorNo()) {
					echo($indexQuery);
					echo(sql::error());
					echo("	index $dir : NOK\n")	;
				} else {
					echo("	index $dir : ok\n")	;
				}
			}
			unset($indexqueries);
		}
		
	}
}


//	Initialise la base de données avec les requetes stockes dans le dossier des modules
//	dans les fichiers només initdb.sql

if (in_array("--initdb", $argv)) {
	foreach($dirs as $dir) {
		if (file_exists(PATH_MODULES . $dir . PATH_SEP ."initdb.sql")) {
			$query = file_get_contents(PATH_MODULES . $dir . PATH_SEP ."initdb.sql");
			
			if (trim($query) != "") {
				sql::query($query);
				if (sql::errorNo()) {
					echo($query);
					echo(sql::error());
					echo("$dir : NOK\n")	;
				} else {
					echo("$dir : ok\n")	;
				}
			}
		}
	}
}

