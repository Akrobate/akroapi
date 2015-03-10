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
