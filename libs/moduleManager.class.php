<?php

/**
 * @brief		Classe qui gere les modules
 * @details		Permet de listes/manipules les modules
 * @author		Artiom FEDOROV
 */
 
class ModuleManager {

	/**
	 * @brief		Méthode de recuperation de tous les modules
	 * @details		Renvoi le tableau de modules
	 * @return	array		Renvoi le tableau de modules
	 */

	public static function getAllModules() {
		return self::getModulesFromDir(PATH_MODULES);
	}


	/**
	 * @brief		Méthode de recuperation des modules internes
	 * @details		Les modules internes se trouvent dans le core
	 * @return	array		Renvoi le tableau de modules internes
	 */
	 
	public static function getAllInternalModules() {
		return self::getModulesFromDir(PATH_CORE_INTERNAL_MODULES);
	}
	
	
	/**
	 * @brief		Recupère tous les modules en partnat d'un dossier
	 * @details		Tous les modules declarés dans un repertoire sont listés et renvoyés sous forme
	 *				de tableau
	 * @param	path		Prend en parametre le chemin vers le dossier des modules
	 * @return	array		Renvoi le tableau de modules internes
	 */
	 
	public static function getModulesFromDir($path) {
		$dirs = scandir($path);
		$rez = array();
		foreach($dirs as $dir) {
			if(($dir != "..") && ($dir != ".") && ((strpos($dir, ".") === false))) {
				$rez[] = $dir;
			}
		}
		return $rez;
	}
	

	 
	public static function getActionsFromSTDModule($module, $action) {
		$dirs = scandir(PATH_CORE_STD_MODULES);

		$rez = array();
		foreach($dirs as $dir) {
			if(($dir != "..") && ($dir != ".") && ((strpos($dir, ".svn") === false))) {
				$rez[] = str_replace('.php','', $dir);
			}
		}
		return $rez;
	}
	
	
	public static function ActionExistInSTDModule($module, $action) {
		$actions = self::getActionsFromSTDModule($module, $action);
		return in_array($action,$actions);
	}



	public static function ActionExistInModule($module, $action) {

			$moduleName = ucfirst($module);			
			$actionName = ucfirst($action);
	
			$customName = 'Modules_' . $moduleName . '_' . $actionName;
			$coreName = 'Module_' . $actionName;
	
			$exists = false;
			if (CoreController::controllerExists($customName)) {
				$exists = true;
			} elseif(CoreController::controllerExists($coreName)) {
				$exists = true;
			}
			
			return $exists;
			
	}
		
	/**
	 * @brief		Determine si un module existe ou pas
	 * @details		
	 * @param	module		le nom du module a triater
	 * @return	bool		Renvoi true si existe, false sinon
	 */
	 
	public static function modulesExists($module) {
		$modules = self::getAllModules();
		return in_array($module,$modules);
	}
	
	/**
	 * @brief		Récupère toutes les jointures d'un module
	 * @details		Répcupere toutes les jointures d'un module depuis les variables $fields
	 * @param	module		Prends en parametre le nom du module
	 * @return	array		Renvoi le tableau des jointures des modules
	 */
	 
	public static function getJoinsOnModule($module) {
		$ret = array();
		$allmodules = self::getAllModules();
		foreach($allmodules as $mod) {
			$fields = OrmNode::getFieldsFor($mod);
			foreach($fields as $k=>$v) {
				if (isset($v['join']['table']) && $v['join']['table'] == $module) {
					$ret[$mod][$k] = $v;
				}
			}
		}
		return $ret;
	}
}
