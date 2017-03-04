<?php

/**
 *	Fichier de configuration de champs pour le module :
 *	
 *		--- Session Data ---
 *
 * @brief		Definition du modele de offers
 * @details		Definition des champs de la table offers
 *
 * @author		Artiom FEDOROV
 *
 */

$table['engine'] = "InnoDB";

$fields['id_session']['type'] = 'int';
$fields['id_session']['label'] = 'Id session';
 
$fields['data']['type'] = 'text';
$fields['data']['label'] = 'Data';

