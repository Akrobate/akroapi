<?php

/**
 *	Fichier de configuration de champs pour le module 
 *
 *	---ACL Scripts----
 *
 * @brief		Definition du modele de BookMarks
 * @details		Definition des champs de la table BookMarks
 *
 * @author		Artiom FEDOROV
 *
 */


$table['engine'] = "InnoDb";
 

$fields['id_group']['type'] = 'int';
$fields['id_group']['label'] = 'Id du groupe';


// Type d'acces: Public / Auth / Grant
$fields['access']['type'] = 'smalltext';
$fields['access']['label'] = "Type d'accès";

$fields['module']['type'] = 'smalltext';
$fields['module']['label'] = "nom du module";

$fields['action']['type'] = 'smalltext';
$fields['action']['label'] = "Nom de l'action";

$fields['created']['type'] = 'datetime';
$fields['created']['label'] = 'Date de creation';


$indexqueries = array();
$indexqueries[] = "ALTER TABLE `acl` ADD INDEX `id_group` ( id_group );";
$indexqueries[] = "ALTER TABLE `acl` ADD INDEX `access` ( `access` );";
