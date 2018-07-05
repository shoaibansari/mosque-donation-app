<?php

use Illuminate\Database\Seeder;
use \App\Role;

class RolePermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $seed = \App\RolePermission::getSeedData();
	    DB::table( 'role_permissions' )->truncate();
	    DB::table( 'role_permissions' )->insert( $seed );
    }
}
