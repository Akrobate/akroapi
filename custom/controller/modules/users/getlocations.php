<?php

/**
 *	Controlleur générique de visualisation de la liste de resultats
 *	Permet la visualisation de toutes les données
 *	De l'enregistrement
 *
 *	@author	Artiom FEDOROV
 *	@date	2014
 */

class Modules_Users_Getlocations extends CoreController {


	/** 
	 *	@brief	Méthode init qui recupere la liste de resultats
	 *	@details	Affiche la liste de contenus
	 *
	 */

	public function init() {
		
		$skills = array();		
		if (users::isConnected()) {
		
			$iduser = users::getId();
			
			$query = "SELECT * FROM userslocations
						LEFT JOIN locations ON userslocations.id_location = locations.id 
						WHERE userslocations.id_user = " . $iduser;
						
			sql::query($query);
			if(sql::errorNo()) {
				echo(sql::error());
			}
			while($skill = sql::fetchAssoc()) {
				$skills[] = $skill;
			}
		}
		
		$this->assign('locations', $skills);
		//$this->getCallerClass()->result = "customanswer";
	}

}
