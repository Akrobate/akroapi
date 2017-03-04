<?php

/**
 *	Fichier de configuration de champs pour le module :
 *	
 *		--- Session ---
 *
 * @brief		Definition du modele de offers
 * @details		Definition des champs de la table offers
 *
 * @author		Artiom FEDOROV
 *
 */

$table['engine'] = "MEMORY";
 
$fields['sessionid']['type'] = 'textid64';
$fields['sessionid']['label'] = 'Id';
 
$fields['data']['type'] = 'bigvarchar';
$fields['data']['label'] = 'Data';

$fields['created']['type'] = 'datetime';
$fields['created']['label'] = 'Date de création';

$fields['updated']['type'] = 'datetime';
$fields['updated']['label'] = "Date de mise a jour";

$fields['timestamp']['type'] = 'int';
$fields['timestamp']['label'] = "Timestamp";


$indexqueries = array();
$indexqueries[] = "ALTER TABLE `realtimejobbing`.`sessions` ADD INDEX `sessionid` ( `sessionid` );";

