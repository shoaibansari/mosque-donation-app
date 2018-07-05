<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $data = \App\Role::getSeedData();
		$seed = [];
	    foreach ( $data as $role_id => $item) {
		    $seed[] = [
			    'id'      => $role_id,
			    'title'      => $item[0],
			    'active'     => 1,
			    'created_at' => \Carbon\Carbon::now(),
			    'updated_at' => \Carbon\Carbon::now()
		    ];
	    }

	    DB::table( 'roles' )->truncate();
	    DB::table( 'roles' )->insert( $seed );

    }
}
