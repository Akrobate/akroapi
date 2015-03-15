<?php

/**
 *	Cette classe gere l'inclusion des templates
 *	
 *	@brief	Classe dont extends quasi tous les controlleurs de l'application
 *	
 *	@author	Artiom FEDOROV
 *	@date	19/12/2014
 */

class CoreController {

	public $action;
	public $module;
	public $format;
	public $template;
	public $data;
	
	public $debug = false;
	
	public $callerClass;
	
	public $params;

	public static $headressources = array();
	
	/**
	 *	Constructeur de classe
	 *	@brief	Constructeur du CoreController
	 *	@details	Appelle l'autoload des du template pour set le template
	 */

	public function __construct() {
		if ($this->format != 'json') {	
			$this->autoloadTemplate();
		}
	}


	/**
	 *	Méthode destinée a gerer l'autolaod des js
	 *
	 *	@brief		Methode qui inclut les js dans les path par defaut
	 *	@param		js	Prend en parametre le nom du script js a inclure
	 *	@details	Prend le nom du js explode le nom de la classe pour 
	 *				avoir le path et inclut le fichier js dans le chemin 
	 *				equivalent pour les js
	 */
	 		
	public function addJS($js = "")	{

		if ($js == "") {

			$classname = get_class($this);			
			$action = $this->getAction();			
			$exp = explode("_", strtolower($classname . "_" .$action));
			$str = implode("/", $exp);
			
			if (file_exists(PATH_CORE_RESSOURCES_JS . $str . ".js")) {
				ressources::addJs(URL_CORE_RESSOURCES_JS . $str . ".js");
			}
		} else {
			ressources::addJs($js);
		}
		
	}	


	/**
	 *	Méthode destinée a être surchargée dans les sous controlleurs
	 *
	 */

	public function init() {
	
	}


	/**
	 *	Méthode destinée a être surchargée dans les sous controlleurs
	 *
	 */

	public function preinit() {

	}


	/**s
	 *	Méthode destinée a gerer l'autolaod des templates
	 *	@brief		Methode appelé par le render pour inclure le bon template
	 *	@details	Prends le nom de la classe l'explode selon separateur _ et remplace par le separateur de chemin
	 */
	 
	public function autoloadTemplate() {
	
		$classname = get_class($this);
		$exp2 = explode("_", strtolower($classname));
		$name = strtolower(array_pop($exp2));
		$exp = explode("_", strtolower($classname));
		$str = implode("/", $exp);
		
		// inclusion du template se fait toujours en commencant par custom puis core
		if (file_exists(PATH_CUSTOM_VIEWS . $str . ".php")) {
			$this->template = PATH_CUSTOM_VIEWS . $str . ".php";
		} else {
			if (file_exists(PATH_CORE_VIEWS . $str . ".php")) {
				$this->template = PATH_CORE_VIEWS . $str . ".php";
			} else {
				$this->template = PATH_CORE_VIEWS . 'module/' . $name . ".php";
			}
		}
	}
	
	
	/**
	 *	@brief		Setteur d'Action
	 *	@return		this Renvoi la classe courante
	 */
	
	public function setAction($action) {
		$this->action = $action;
		return $this;		
	}


	/**
	 *	@brief		Setteur de Modules
	 *	@return		this Renvoi la classe courante
	 */
	 
	public function setModule($module) {
		$this->module = $module;
		return $this;
	}


	/**
	 *	@brief		Setteur de format
	 *	@return		this Renvoi la classe courante
	 */

	public function setFormat($format) {
		$this->format = $format;
		return $this;
	}


	/**
	 *	@brief		Setteur de template
	 *	@return		this Renvoi la classe courantes
	 */

	public function setTemplate($tpl) {
		$this->template = $tpl;
		return $this;		
	}
	
	
	/**
	 *	@brief		Setteur de params
	 *	@return		this Renvoi la classe courantes
	 */

	public function setParams($params = array()) {
		$this->params = $params;
		return $this;		
	}
	
	
	/**
	 *	@brief		
	 *	@return		
	 */
	 
	public function setCallerClass($cc) {
		$this->callerClass = $cc;
	}
	
	/**
	 *	@brief		Getteur d'action
	 *	@return		string Renvoi le nom de l'action
	 */
	 
	public function getAction() {
		return $this->action;
	}


	/**
	 *	@brief		On active le debug
	 *	@return		
	 */
	 
	public function onDebug() {
		$this->debug = true;
	}


	/**
	 *	@brief		On desactive le debug
	 *	@return		
	 */
	 
	public function offDebug() {
		$this->debug = false;
	}
	
	
	
	/**
	 *	@brief		On desactive le debug
	 *	@return		
	 */
	 
	public function getDebug() {
		return $this->debug;
	}

	/**
	 *	@brief		Getteur de modules
	 *	@return		string Renvoi le nom module
	 */

	public function getModule() {
		return $this->module;
	}
	
	
	/**
	 *	@brief		Getteur de format
	 *	@return		string Renvoi le format
	 */
	
	public function getFormat() {
		return $this->format;
	}


	/**
	 *	@brief		Getteur de params
	 *	@return		Renvoi les params
	 */

	public function getParams() {
		return $this->params;		
	}
	
	
	/**
	 *	@brief		
	 *	@return		
	 */

	public function getCallerClass() {
		return $this->callerClass;		
	}
	
	/**
	 *	@brief		Assigne la variable
	 *	@details	Assigne la variable pour un usage dans les templates
	 *	@return		this Renvoi la classe courantes
	 */

	public function assign($name,$val) {
		$this->data[$name] = $val;
		return $this;		
	}
	
	
	/**
	 *	@brief		Getteur de variables de template
	 *	@details	Retourne la variable si celle la existe
	 *	@param		name	Nom de la variable de template a renvoyer
	 *	@return		string	Retourne la variable si celle la existe
	 */
	 
	public function getvar($name) {
		return $this->data[$name];
	}	


	/**
	 *	@brief		Méthode qui execute l'ensemble du processus
	 *	@return 	string	Renvoi le rendu vers la sortie standard
	 *
	 */

	public function render() {
		echo $this->renderSTR();
	}
	

	/**
	 *	@brief		Méthode qui execute l'ensemble du processus
	 *	@return 	string	Renvoi le rendu dans une variable
	 *
	 */
	 
	public function renderSTR() {
		$this->preinit();
		$this->init();
		$content = "";
		if ($this->isFormatJson()) {
			if ($this->getJsonDataForApi()) {
				$content = $this->getJsonDataForApi();
				echo($content);
			}
		} else {
			ob_start();
			if (count($this->data)){
				extract($this->data);
			}
			include($this->template);
			$content = ob_get_contents();
			ob_end_clean();
		}
		return $content;
	}


	/**
	 *	@brief		Méthode qui execute et renvoi du JSON
	 *	@return 	renvoi le JSON
	 *
	 */
	 
	public function getJSON() {
		$this->preinit();
		$this->init();
		return json_encode($this->data);
	}


/**
	 *	@brief		Méthode qui execute et renvoi du JSON
	 *	@return 	renvoi le JSON
	 *
	 */
	 
	public function getArray() {
		$this->preinit();
		$this->init();
		return $this->data;
	}



	/**
	 *	@brief		Méthode qui execute l'ensemble du processus
	 *	@return 	string	Renvoi le rendu vers la sortie standard
	 *
	 */

	public function renderJSON() {
		echo $this->getJSON();
	}
	

	/**
	 *	@brief		Méthode de detection du format json
	 *	@return 	bool	Renvoi si le template courant est en mode json
	 *
	 */

	public function isFormatJson() {
		return ($this->format == 'json');
	}


	/**
	 *	@brief	Methode permettant de render du json
	 *
	 */

	public function getJsonDataForApi() {
	
		if (isset($this->data['datasForApi'])) {
			return json_encode($this->data['datasForApi']);		
		} else {
			return false;
		}
	}


	/**
	 *	@brief		Méthode statique de partage de proprietés
	 *	@details	Partage des propriétés generiques entre classe qui extends de CoreController
	 *	@param	from	CoreController Object	D'ou l'on copie
	 *	@param	to		CoreController vers leque on copie les proprietes
	 */

	public static function share($from, $to) {
		$to->setAction($from->getAction());
		$to->setModule($from->getModule());
		$to->setFormat($from->getFormat());
		$to->setParams($from->getParams());
		$to->setCallerClass($from);
	}
	
	
	/**
	 *	@brief		Methode de verification de l'existance d'une classe
	 *	@details	Methode qui determine si le fichier d'une classe existe
	 *				Selon la regle suivante: les séparateurs type "_" sont les separateurs de dossier: '/'
	 *				puis le tout est ramené en minuscules, puis on cherche l'existance d'abord 
	 *				dans PATH_CORE_CONTROLLER puis dans PATH_CUSTOM_CONTROLLER
	 *
	 *	@return		bool	Renvoi vrai si inclusion reussi et false sinon
	 */
	
	public static function controllerExists($controller) {	
		$path = "";		
		$explode = explode("_",$controller);
		$filename = strtolower(array_pop($explode));
		if (count($explode) > 0) {
			foreach($explode as $ex) {
				$path .= strtolower($ex) . '/';
			}
		}
		
		if (file_exists(PATH_CORE_CONTROLLER . $path . $filename . '.php')) {
			return true;
		} elseif (file_exists(PATH_CUSTOM_CONTROLLER . $path . $filename . '.php')) {
			return true;
		} else {
			return false;
		}
	}
	

}
