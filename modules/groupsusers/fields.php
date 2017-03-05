<?php

/**
 *	Fichier de configuration de champs pour le module 
 *
 *	--- Groups / Users
 *
 *
 * @brief		Definition du modele de Users / Location
 * @details		Definition des champs de la table userslocation
 *				ACL pour definir les groupes auquels appartient les utilisateurs
 *
 * @author		Artiom FEDOROV
 *
 */

$table['engine'] = "InnoDb";

$fields['id_user']['type'] = 'join';
$fields['id_user']['label'] = 'Utilisateur';
$fields['id_user']['join']['table'] = 'users';
$fields['id_user']['join']['field'] = 'firstname';
$fields['id_user']['join']['type'] = '1-n';


$fields['id_group']['type'] = 'join';
$fields['id_group']['label'] = 'groupe';
$fields['id_group']['join']['table'] = 'groups';
$fields['id_group']['join']['field'] = 'name';
$fields['id_group']['join']['type'] = '1-n';

$indexqueries = array();
$indexqueries[] = "ALTER TABLE `groupsusers` ADD INDEX `id_user` ( `id_user` );";
$indexqueries[] = "ALTER TABLE `groupsusers` ADD INDEX `id_group` ( `id_group` );";
