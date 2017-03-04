<?php

/**
 *	Fichier de configuration de champs pour le module 
 *
 *	---ACL Groups ----
 *
 * @brief		Definition du modele de BookMarks
 * @details		Definition des champs de la table BookMarks
 *
 * @author		Artiom FEDOROV
 *
 */

$table['engine'] = "InnoDb";

$fields['name']['type'] = 'text';
$fields['name']['label'] = "Nom du groupe";

$fields['description']['type'] = 'text';
$fields['description']['label'] = "Détails à propos du groupe";

$fields['created']['type'] = 'datetime';
$fields['created']['label'] = 'Date de creation';


