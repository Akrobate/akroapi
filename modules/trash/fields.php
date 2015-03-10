<?php

/**
 *	Fichier de configuration de champs pour le module Trash
 *
 * @brief		Definition du modele de Trash
 * @details		Definition des champs de la table Trash
 *
 * @author		Artiom FEDOROV
 *
 */


$fields['id_owner']['type'] = 'join';
$fields['id_owner']['label'] = 'Owner';
$fields['id_owner']['join']['table'] = 'owners';
$fields['id_owner']['join']['field'] = 'owner';
$fields['id_owner']['join']['type'] = '1-n';

$fields['id_word']['type'] = 'join';
$fields['id_word']['label'] = 'Word';
$fields['id_word']['join']['table'] = 'words';
$fields['id_word']['join']['field'] = 'text';
$fields['id_word']['join']['type'] = '1-n';

$fields['created']['type'] = 'datetime';
$fields['created']['label'] = 'Date de creation';

