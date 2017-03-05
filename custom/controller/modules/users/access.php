<?php

/**
 *	Controlleur générique de visualisation de la liste de resultats
 *	Permet la visualisation de toutes les données
 *	De l'enregistrement
 *
 *	@author	Artiom FEDOROV
 *	@date	2014
 */

class Modules_Users_Access extends CoreController {


	/** 
	 *	@brief	Méthode init qui recupere la liste de resultats
	 *	@details	Affiche la liste de contenus
	 *
	 */

	public function init() {
		
		$module = $this->getModule();
		
		$profile = users::getProfile();
		
		//$this->total = $orm->total;		
		$this->assign('acl', $profile);
		
		if (users::isConnected()) {
			$connected = "yes";
		} else {
			$connected = "no";
		}
		
		$this->assign('connected', $connected);
		
		//$this->getCallerClass()->result = "customanswer";
	}

}
