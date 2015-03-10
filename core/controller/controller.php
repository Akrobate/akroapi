<?

/**
 *	Classe principale
 *	S'occupe d'integrer la bonne classe selon 
 *	les requetes, un genre de vrai routeur
 *
 *
 */


class Controller extends CoreController {


	/**
	 * 
	 *	@briefMethode Point d'entrée de l'application
	 *	Ici always connected
	 *
	 */

	public function init() {
		if (users::isConnected() || 1) {
			$this->whenConnected();
		} else {
			$this->whenNotConnected();
		}
	}
	
	
	/**
	 *	@brief methode appelé quand l'utilisateur est connectée
	 *
	 */
	
	public function whenConnected() {
	
		if ($this->action != "") {
		
			$moduleName = ucfirst($this->module);			
			$actionName = ucfirst($this->action);
	
			$customName = 'Modules_' . $moduleName . '_' . $actionName;
			$coreName = 'Module_' . $actionName;
	
			if (CoreController::controllerExists($customName)) {
				$ctrName = $customName;
			} elseif(CoreController::controllerExists($coreName)) {
				$ctrName = $coreName;			
			}
	
			$obj = new $ctrName();		
			CoreController::share($this, $obj);
			$this->assign('right', $obj->renderSTR());
		}

		//	$allModules = ModuleManager::getAllModules();
		//	$this->assign('topLinks', $allModules);
		//	$this->assign('left', $obj->renderJSON());
	}
	
	
	
	/**
	 *	@brief methode appelé quand l'utilisateur est n'est pas connecté
	 */
	
	public function whenNotConnected() {
	
		$customName = 'Modules_Users_Login';
		$obj = new $customName();
		$this->assign('sidebar', false);
		$objstr = $obj->renderSTR();
		$this->assign('middle', $objstr);
	}
	
}


