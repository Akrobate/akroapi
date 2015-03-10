<?php

/**
 *	Controlleur générique de visualisation de la liste de resultats
 *	Permet la visualisation de toutes les données
 *	De l'enregistrement
 *
 *	@author	Artiom FEDOROV
 *	@date	2014
 */

class Module_Index extends CoreController {


	/** 
	 *	@brief	Méthode init qui recupere la liste de resultats
	 *	@details	Affiche la liste de contenus
	 *
	 */

	public function init() {
		$id = request::get('id');
		$module = $this->getModule();
		$list = new List_Frameview();
		$views = users::getProfile();

		if (isset($views['view'][$module]['list']['filter'])){
			$list->setFilter($views['view'][$module]['list']['filter']);
		}
		CoreController::share($this, $list);
		$listContent = $list->renderSTR();
		$this->assign('listContent', $listContent);
		
	}
}
