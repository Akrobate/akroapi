<?

/**
 *	Classe principale
 *	S'occupe d'integrer la bonne classe selon 
 *	les requetes, un genre de vrai routeur
 *
 *
 *	ErrorsCode	success 200;
 *				module_missing 210
 *				action_missing 220
 *				
 *
 *
 *
 *
 */


class Controller extends CoreController {


	public $result = "success";
	public $errorId = 200;
	/**
	 * 
	 *	@briefMethode Point d'entrée de l'application
	 *	Ici always connected
	 *
	 */

	public function init() {
	
	
		if($this->ModuleAndActionExists()) {
			$this->ProcessIt();
		} else {
			$this->ModuleOrActionNotFound();
		}
		
	}
	
	
	/**
	 *	@brief methode appelé quand l'utilisateur est connectée
	 *
	 */
	
	public function ProcessIt() {
	
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
			echo($ctrName);
			// Création de l'objet enfant en fonction des params
			$obj = new $ctrName();
			CoreController::share($this, $obj);
			
			// assignation et execution de l'objet enfant.
			$this->assign('data', $obj->getArray());
			
			$this->assign('action', $this->action);
			$this->assign('module', $this->module);
			$this->assign('result', $this->result);
			$this->assign('errorId', $this->errorId);			
			
		}

	}
	
	
	
	/**
	 *	@brief methode appelé quand l'utilisateur est n'est pas connecté
	 */
	
	public function ModuleOrActionNotFound() {
	
		$this->assign('action', $this->action);
		$this->assign('module', $this->module);
		$this->assign('result', $this->result);
		$this->assign('errorId', $this->errorId);
	}
	
	
	
	
	
	
	public function ModuleAndActionExists() {
		$exists = false;
		if (ModuleManager::modulesExists($this->module)) {		
			if(ModuleManager::ActionExistInModule($this->module, $this->action)) {
				//$this->result = "";
				$this->errorId = 200;
				$exists = true;
			} else {
				$this->result = "Action Missing";
				$this->errorId = 220;				
			}
		} else {
			$this->result = "Module Missing";
			$this->errorId = 210;
		}
		return $exists;		
	}
	
}


