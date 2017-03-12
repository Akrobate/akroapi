<?php

/**
 *	Configuration file for datastorage of
 *	a generic item testitem
 *
 * @brief
 * @details		Definition des champs de la table Trash
 *
 * @author		Artiom FEDOROV
 *
 */

/*
$fields['testtext']['type'] = 'text';
$fields['testtext']['label'] = 'Test text';

$fields['created']['type'] = 'datetime';
$fields['created']['label'] = 'Creation date';
*/

$fields = [
    'testtext' => [
        'type' => 'text',
        'label' => 'Test text'
    ],
    'owner_user_id' => [
        'type' => 'int',
        'label' => 'User own data'
    ],
    'created' => [
        'type' => 'datetime',
        'label' => 'Creation date'
    ]
];
