<?php

/**
 *	Controlleur générique de visualisation de la liste de resultats
 *	Permet la visualisation de toutes les données
 *	De l'enregistrement
 *
 *	@author	Artiom FEDOROV
 *	@date	2014
 */

class Modules_Words_Search extends CoreController {

	const NBR_METERS_SEARCHING = 30;


	/** 
	 *	@brief	Méthode init qui recupere la liste de resultats
	 *	@details	Affiche la liste de contenus
	 *
	 * //	$orm->start_limit = $this->start;
	 * //	$orm->nbr_limit = $this->nbr;		
	 * //	$orm->setFilter(" (altitude = '$altitude') AND (longitude >= '$longitude') AND (latitude = '$latitude') ");
	 *
	 */

	public function init() {

		$params = $this->getParams();

		$longitude = $params->longitude;
		$latitude = $params->latitude;
		$altitude = $params->altitude;

		$orm = new OrmNode();
		$module = $this->getModule();
		
		$listFields = OrmNode::getFieldsFor($module);
		$listFields['id'] = array('label'=>'id', 'type'=>'int');
		
		$enlargedCoords = SimpleCoords::getLargeCoords($latitude, $longitude, self::NBR_METERS_SEARCHING);
		
		$orm->setFilter(" (altitude = '$altitude')
							 AND (longitude <= '{$enlargedCoords['east']['long']}') 
							 AND (longitude >= '{$enlargedCoords['west']['long']}') 		
							 AND (latitude <= '{$enlargedCoords['north']['lat']}')
							 AND (latitude >= '{$enlargedCoords['south']['lat']}') ");
		
		$content = $orm->getAllData($this->getModule(), $listFields);
		//$this->total =;
		
		$this->assign('found', $content);
		$this->assign('nbr',  $orm->total);
		$this->getCallerClass()->result = "success";
	}

}
