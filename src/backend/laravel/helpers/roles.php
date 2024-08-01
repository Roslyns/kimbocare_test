<?php 


 /**
 *                LISTE DES ROLES DU SYSTEME
 *============================================================
 *
 */

 if(!defined('PLAYER_ROLE')) define('PLAYER_ROLE',
 [
     'name'=> 'PLAYER',
     'description' => 'PLAYER role',
 ]);

if(!defined('MANAER_ROLE')) define('MANAER_ROLE', 
 [
     'name'=> 'MANAER',
     'description' => 'MANAER role',
 ]);

if(!defined('ADMIN_ROLE')) define('ADMIN_ROLE', 
 [
     'name'=> 'ADMIN',
     'description' => 'ADMIN role',
 ]);
 
if(!defined('ROLE_LIST')) define('ROLE_LIST', 
 [
     PLAYER_ROLE, 
     MANAER_ROLE,
     ADMIN_ROLE, 
]);


