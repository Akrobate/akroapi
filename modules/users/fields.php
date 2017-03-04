<?php

/**
 *	Fichier de configuration de champs pour le module Owner
 *
 * @brief		Definition du modele de Owner
 * @details		Definition des champs de la table owner
 *
 * @author		Artiom FEDOROV
 *
 */

$table['engine'] = "InnoDb";

$fields['androidid']['type'] = 'androidid';
$fields['androidid']['label'] = 'Id Android';

$fields['usertype']['type'] = 'smalltext';
$fields['usertype']['label'] = "Type d'utilisateur";

$fields['firstname']['type'] = 'text';
$fields['firstname']['label'] = 'Prenom';

$fields['lastname']['type'] = 'text';
$fields['lastname']['label'] = 'Nom';

$fields['phone']['type'] = 'text';
$fields['phone']['label'] = 'Telephone';

$fields['email']['type'] = 'text';
$fields['email']['label'] = 'email';

$fields['photourl']['type'] = 'text';
$fields['photourl']['label'] = 'Url de la photo';


$fields['password']['type'] = 'text';
$fields['password']['label'] = 'Mot de passe';

$fields['status']['type'] = 'smalltext';
$fields['status']['label'] = "Status de l'utilisateur";

$fields['updated']['type'] = 'datetime';
$fields['updated']['label'] = 'Date de mise a jour';

$fields['created']['type'] = 'datetime';
$fields['created']['label'] = 'Date de creation';


$indexqueries = array();
$indexqueries[] = "ALTER TABLE `realtimejobbing`.`users` ADD INDEX `emailpassword` ( `email` , `password` );";
$indexqueries[] = "ALTER TABLE `realtimejobbing`.`users` ADD INDEX `usertype` ( `usertype` );";
$indexqueries[] = "ALTER TABLE `realtimejobbing`.`users` ADD INDEX `status` ( `status` );";





