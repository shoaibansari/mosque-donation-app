<?php

use Illuminate\Database\Seeder;

class PermissionGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $data = \App\PermissionGroup::getSeedData();
	    DB::table( 'permission_groups' )->truncate();
	    foreach ($data as $id => $item) {
		    DB::table( 'permission_groups' )->insert(
			    [
				    'id'         => $id,
				    'title'      => $item,
				    'active'     => 1,
				    'created_at' => \Carbon\Carbon::now(),
				    'updated_at' => \Carbon\Carbon::now()
			    ]
		    );
	    }
    }
}
