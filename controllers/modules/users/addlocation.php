<?php

/**
 *	Controlleur générique de visualisation de la liste de resultats
 *	Permet la visualisation de toutes les données
 *	De l'enregistrement
 *
 *	@author	Artiom FEDOROV
 *	@date	2014
 */

class Modules_Users_Addlocation extends CoreController {


	/** 
	 *	@brief	Méthode init qui recupere la liste de resultats
	 *	@details	Affiche la liste de contenus
	 *
	 */

	public function init() {
		$locations = array();
		
		$params = $this->getParams();
		if (isset($params->id)) {
			$idparam = $params->id;
			if (users::isConnected()) {
				$iduser = users::getId();
				$query = "SELECT * FROM userslocations WHERE id_user = " . $iduser . " AND id_location=" . $idparam;
				sql::query($query);	
				if (sql::nbrRows() == 0) {
					$query = "INSERT INTO userslocations (id_user, id_location, created) VALUES ({$iduser},{$idparam},NOW())";
					sql::query($query);
					if(sql::errorNo()) {
						echo(sql::error());
					}
				}
			}
			$this->assign('status', "ok");		
		} else {
			$this->assign('status', "error");
			$this->getCallerClass()->result = "Param missing";
		}
	}

}
