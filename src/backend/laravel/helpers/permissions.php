<?php


/**
 *  PLAYER_PERMISSIONS
 */
$PLAYER_PERMISSIONS = [
    [
        'name' => 'update_player_infos',
        'description' => 'Mettre à jour les informations d\'un player.',
    ],
];


/**
 * MANAER_PERMISSIONS
 */
$MANAER_PERMISSIONS = [
    ...$PLAYER_PERMISSIONS,
    [
        'name' => 'consulter_info_conseil_d',
        'description' => 'Consuter les informations du conseil de discipline',
    ],
];

/**
 * ADMINITRATEUR_PERMISSIONS
 */
$ADMINITRATEUR_PERMISSIONS = [
    ...$MANAER_PERMISSIONS,
    [
        'name' => 'creer_player',
        'description' => 'Creer un player',
    ],
    
    [
        'name' => 'supprimer_player',
        'description' => 'Supprimer un player',
    ],
    [
        'name' => 'delete_manager',
        'description' => 'Supprimer un manager',
    ],
    [
        'name' => 'create_manager',
        'description' => 'Créer un manager',
    ],

];



 /**
 *                LISTE DES PERMISSION DU SYSTEME
 *                       GROUPEES PAR ROLES
 *============================================================
 *
 */

if(!defined('PLAYER_PERMISSIONS')) define('PLAYER_PERMISSIONS', $PLAYER_PERMISSIONS);
if(!defined('MANAER_PERMISSIONS')) define('MANAER_PERMISSIONS', $MANAER_PERMISSIONS);
if(!defined('ADMINITRATEUR_PERMISSIONS')) define('ADMINITRATEUR_PERMISSIONS',$ADMINITRATEUR_PERMISSIONS);
if(!defined('ALL_SYSTEME_PERMISSIONS')) define('ALL_SYSTEME_PERMISSIONS',$ADMINITRATEUR_PERMISSIONS);

