<?php

/**
 *	Controlleur générique de visualisation de la liste de resultats
 *	Permet la visualisation de toutes les données
 *	De l'enregistrement
 *
 *	@author	Artiom FEDOROV
 *	@date	2014
 */

class Modules_Users_Removeskill extends CoreController {


	/** 
	 *	@brief	Méthode init qui recupere la liste de resultats
	 *	@details	Affiche la liste de contenus
	 *
	 */

	public function init() {

		$params = $this->getParams();
		if (isset($params->id)) {
			$idparam = $params->id;
			if (users::isConnected()) {
				$iduser = users::getId();
				$query = "DELETE FROM usersskills WHERE id_user = {$iduser} AND id_skill = {$idparam}";
				sql::query($query);
				
			}
			$this->assign('status', "ok");		
		} else {
			$this->assign('status', "error");
			$this->getCallerClass()->result = "Param missing";
		}
	}

}
