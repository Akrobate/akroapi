<?php

/**
 * @brief		Classe controlleur de la page d'acceuil
 * @details		Controlleur permettant de manipuler les dashlets
 *				de la page d'accueil
 *				
 * @author		Artiom FEDOROV
 */
 
class Modules_Home_Index extends CoreController {


	/**
	 *	Point d'execution du programme
	 *	traitement generique pour le moment on recupere tous les modules
	 *	Puis on genere leurs dashlet
	 *
	 */

	public function init() {
	s
		$modules = ModuleManager::getAllModules();
		$dashlets = array();
		
		
		foreach($modules as $module) {

			$moduleName = ucfirst($module);			
			$actionName = "Dashlet";
			$customName = 'Modules_' . $moduleName . '_' . $actionName;
			$coreName = 'Module_' . $actionName;
	
			if (CoreController::controllerExists($customName)) {
				$ctrName = $customName;
			} elseif(CoreController::controllerExists($coreName)) {
				$ctrName = $coreName;			
			}	
			$obj = new $ctrName();		
			CoreController::share($this, $obj);
			$obj->setModule($module);
			$dashlets[] = $obj->renderSTR();
		}
		$this->assign('dashlets', $dashlets);
	}
}
