<?php

/**
 *	Script de build du CRM
 *	
 *	@brief		Script permettant la customization d'un module
 *	@details	Effectue une copie complete dans un dossier custom de core/module
 *
 *	@usage		clear;php customize.php --module=notes --action=edit
 *	
 *	@author 	Artiom FEDOROV
 */
 
define('PATH_CURRENT', "../");
require_once("api.php");
$dirs = scandir(PATH_MODULES);
error_reporting(15);
$tree = array();
sql::display(1);


// Traitement des paramètres
foreach($argv as $a) {
	if (strpos($a, 'module') !== false) {
		$exp = explode("=", $a);
		$val = $exp[1];
		$module = trim($val);
	}
	
	if (strpos($a, 'action') !== false) {
		$exp = explode("=", $a);
		$val = $exp[1];
		$actions = trim($val);
		if (strpos($actions, ",") !== false) {
			$actions = explode(",",$actions);
		} else {
			$actions = (array)$actions;
		}		
	}

	if (strpos($a, 'remove') !== false) {
		$exp = explode("=", $a);
		$val = $exp[1];
		$remove = true;		
	} else {
		$remove = false;
	}		
}

$module = trim(strtolower($module));

// On empece de continuer si on trouve pas de module dans l'arg
if ($module == "") {
	exit();
	echo("No module in param\n");
}


// On verifie si le dossier existe:
if (file_exists(PATH_CUSTOM_CONTROLLER .  'modules/' . $module)) {
	echo("exists\n");
} else {
	echo("Do not exists \n");
	echo("Creating \n");
	echo(PATH_CUSTOM_CONTROLLER .  'modules/' . $module . "\n");
	mkdir(PATH_CUSTOM_CONTROLLER .  'modules/' . $module);
}


foreach($actions as $action) {
	$str = file_get_contents(PATH_CORE_CONTROLLER .  'module/' . $action . ".php");
	$coreName = 'Module_' . ucfirst($action);
	$customName = 'Modules_' . ucfirst($module) . "_" . ucfirst($action);	
	$str = str_replace($coreName, $customName, $str);
	file_put_contents(PATH_CUSTOM_CONTROLLER .  'modules/' . $module . "/" . $action . ".php", $str);
	echo($customName . "\n");
}

