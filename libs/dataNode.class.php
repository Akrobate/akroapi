<?php

/**
 *	Classe boite a outils pour les Data nodes 
 *	Permet d'initier les population de divers modules
 *
 *	@author 	Artiom FEDOROV
 */

class DataNode {


	/**
	 *	Créé de la data de maniere aléatoire 
	 *	@brief	Permet de peupler n'importe quel module
	 *	@details	genere de la data aléatoire basé sur du lorem ipsum
	 */

	public static function peopleTable($name, $params = array()) {
		if (!empty($name)) {
			  
			  $data = "ed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur";
			  
			  $ex_data = explode(" ", $data);
			  $count_ex_data = count($ex_data);
			  $count_ex_data_init = $count_ex_data - 3;
			  
			  $nb_val = rand(1,3);
			  $cur_val = rand(1,$count_ex_data_init);
			  
			  $value = "";
			  for($i = $cur_val; $i < $cur_val + $nb_val; $i++) {
			  	$value .= $ex_data[$i] . " ";
			  }
			  
			  $value = trim($value);
			  
			  $data = array();
			 foreach( $params as $fieldname => $val ) {
			 
			 	  $nb_val = rand(1,3);
				  $cur_val = rand(1,$count_ex_data_init);
				  
				  $value = "";
				  for($i = $cur_val; $i < $cur_val + $nb_val; $i++) {
				  	$value .= $ex_data[$i] . " ";
				  }
			 
			 	if ($val['typeSQL'] == 'int') {
					$data[$fieldname] = $value;
			 	} else if ($val['type'] == 'date') {	 
					$data[$fieldname] = $value;
				} else {
					$data[$fieldname] = $value;		
				}
			 }
			  
			return $data;
		}
	}
}
