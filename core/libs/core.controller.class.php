<?php

/**
 *	Cette classe gere l'inclusion des templates
 *	
 *	@brief	Classe dont extends quasi tous les controlleurs de l'application
 *	
 *	@details	Classe permettant servant de coquille a toutes les autres datas.
 *				Certains comportement sont implementés en mode generique
 *
 *				Le code des classes héritantes est dans init() et preinit()
 *				Toute forme de render execute le processus
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
	 *	@brief		Méthode renvoi data
	 *	@return 	renvoi array
	 *
	 */
	 
	public function getData() {
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
	 *				dans PATH_CORE_CONTROLLER puis dans PATH_CONTROLLER
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
		} elseif (file_exists(PATH_CONTROLLER . $path . $filename . '.php')) {
			return true;
		} else {
			return false;
		}
	}
	

}
