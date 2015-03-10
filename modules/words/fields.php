<?php

/**
 *	Fichier de configuration de champs pour le module Words
 *
 * @brief		Definition du modele de Words
 * @details		Definition des champs de la table Words
 *
 * @author		Artiom FEDOROV
 *
 */


$fields['text']['type'] = 'largetext';
$fields['text']['label'] = 'Contenu de votre note';

$fields['longitude']['type'] = 'coords';
$fields['longitude']['label'] = 'Longitude';

$fields['latitude']['type'] = 'coords';
$fields['latitude']['label'] = 'Latitude';

$fields['altitude']['type'] = 'altitude';
$fields['altitude']['label'] = 'Altitude';

$fields['id_owner']['type'] = 'join';
$fields['id_owner']['label'] = 'Owner';
$fields['id_owner']['join']['table'] = 'owners';
$fields['id_owner']['join']['field'] = 'owner';
$fields['id_owner']['join']['type'] = '1-n';

$fields['created']['type'] = 'datetime';
$fields['created']['label'] = 'Date de creation';

