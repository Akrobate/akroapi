<?php

/**
 *	Controlleur générique de visualisation
 *	Permet la visualisation de toutes les données
 *	De l'enregistrement
 *
 *	@author	Artiom FEDOROV
 *	@date	2014
 */

class Module_Myview extends CoreController {

		// id de l'enregistrement a afficher
		public $id;


		/**
		 *	Methode init() surcharge
		 *	On recupere l'ensemble des données ici
		 *	on assigne les donnés aux variables de template
		 *	Appel a la methode de construction de sublistes
		 *
		 */

		public function init() {


            $params = $this->getParams();

			$this->id = $params->id;
			$id = $this->id;
			$this->assign('id', $id);

			// Pour le titre du module
			$mainmodule = $this->getModule();

			// On recupere la liste des champs pour mainmodule
			$fields = OrmNode::getFieldsFor($mainmodule);

			// On recupere toutes les datas
			$data = array();
			$orm = new OrmNode();
			$data = $orm->getData($this->getModule(), $id);

			$this->assign('properties', $data);
			// $lists = $this->getMySublists();
            // $lists = $this->getMySublists();

            // $this->assign('sublists', $lists);
            $this->getCallerClass()->result = "success";

		}


		/**
		 *	Methode de recuperation des sublists
		 *	On recupere l'ensemble des jointures sur l'element courant
		 *	On crée les subpannels
		 *	On assigne le tout aux variables de templates
		 *
		 */

		public function getMySublists() {
			// On recupere les subpannels
			$modulesjoins = ModuleManager::getJoinsOnModule($this->getModule());
			$lists = array();

			foreach ($modulesjoins as $modulename => $module) {
				foreach($module as $key=>$val) {
					$subpannelobj = new List_Subpanel();
					$subpannelobj->setFilter($key . " = " . $this->id);
					$subpannelobj->setModule($modulename);
					$subpannelobj->setAction('view');
					$subpannelobj->setFormat($this->getFormat());
					$lists[] = array('content'=>$subpannelobj->renderSTR(), 'title'=> ucfirst($modulename));
				}
			}
			return $lists;
		}
	}
