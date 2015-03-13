<?php

/**
 * @brief		Classe simple de gestion de coordonnées
 * @details		
 * @author		Artiom FEDOROV
 */


class SimpleCoords {

	
	
	/**
	 * @brief		revoie les coordonnées des 4 points cardinaux augmenté de meters
	 * @details		
 	 *				
	 *				
	 * @param	
	 * @return    
	 */
	
	public function getLargeCoords($lat, $long, $meters) {

		//	$lat = 45.815005; 
		//	$long = 15.978501;
		//	$meters = 500; //Number of meters to calculate coords for north/south/east/west

		$equator_circumference = 6371000; //meters
		$polar_circumference = 6356800; //meters

		$m_per_deg_long = 360 / $polar_circumference;

		$rad_lat = ($lat * M_PI / 180); //convert to radians, cosine takes a radian argument and not a degree argument
		$m_per_deg_lat = 360 / (cos($rad_lat) * $equator_circumference);

		$deg_diff_long = $meters * $m_per_deg_long;  //Number of degrees latitude as you move north/south along the line of longitude
		$deg_diff_lat = $meters * $m_per_deg_lat; //Number of degrees longitude as you move east/west along the line of latitude

		//changing north/south moves along longitude and alters latitudinal coordinates by $meters * meters per degree longitude, moving east/west moves along latitude and changes longitudinal coordinates in much the same way.

		$coordinates['north']['lat'] = $lat + $deg_diff_long;
		$coordinates['north']['long'] = $long;
		$coordinates['south']['lat'] = $lat - $deg_diff_long;
		$coordinates['south']['long'] = $long;

		$coordinates['east']['lat'] = $lat;
		$coordinates['east']['long'] = $long + $deg_diff_lat;  //Might need to swith the long equations for these two depending on whether coordinates are east or west of the prime meridian
		$coordinates['west']['lat'] = $lat;
		$coordinates['west']['long'] = $long - $deg_diff_lat;
		
		return $coordinates;
		
	}
}

	/**
	 * @brief		Réalise une redirection header 301
	 * @details		Peut etre appelé depuis le controlleur          
	 * @param	controller		Nom du controlleur verss lequel on redirige
	 * @param	action			Nom de l'action visée
	 * @param	id				id (optionnel)
	 * @return    null
	 */
