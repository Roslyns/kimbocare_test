<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {

        // LES PERMISSIONS

        $PLAYER_PERMISSIONS = [];
        $MANAER_PERMISSIONS = [];
        $ADMINITRATEUR_PERMISSIONS = [];

        // CREATE PERMISSIONS

        foreach (PLAYER_PERMISSIONS as $permission) {
            $PLAYER_PERMISSIONS = [
                ...$PLAYER_PERMISSIONS,
                Permission::updateOrCreate([
                    'name' => $permission['name'],
                    'description' => $permission['description'],
                    'status' => STATE_ACTIVATED
                ])
            ];
        }
        foreach (MANAER_PERMISSIONS as $permission) {
            $MANAER_PERMISSIONS = [
                ...$MANAER_PERMISSIONS,
                Permission::updateOrCreate([
                    'name' => $permission['name'],
                    'description' => $permission['description'],
                    'status' => STATE_ACTIVATED
                ])
            ];
        }
        foreach (ADMINITRATEUR_PERMISSIONS as $permission) {
            $ADMINITRATEUR_PERMISSIONS = [
                ...$ADMINITRATEUR_PERMISSIONS,
                Permission::updateOrCreate([
                    'name' => $permission['name'],
                    'description' => $permission['description'],
                    'status' => STATE_ACTIVATED
                ])
            ];
        }


        // CREATE ROLES

        $PLAYER_ROLE       = Role::updateOrCreate([...PLAYER_ROLE, 'status' => STATE_ACTIVATED]);
        $MANAER_ROLE      = Role::updateOrCreate([...MANAER_ROLE, 'status' => STATE_ACTIVATED]);
        $ADMIN_ROLE      = Role::updateOrCreate([...ADMIN_ROLE, 'status' => STATE_ACTIVATED]);

        // ASSIGN ROLE TO PERMISSIONS

        foreach($PLAYER_PERMISSIONS as $perm){
            $PLAYER_ROLE->permissions()->attach($perm);
        }
        foreach($MANAER_PERMISSIONS as $perm){
            $MANAER_ROLE->permissions()->attach($perm);
        }
        foreach($ADMINITRATEUR_PERMISSIONS as $perm){
            $ADMIN_ROLE->permissions()->attach($perm);
        }

    }
}
