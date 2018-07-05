<?php

use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$data = array();
	    $data[] = ['user_id' => 1, 'role_id' => \App\Role::TYPE_ADMIN ];
	    $data[] = ['user_id' => 2, 'role_id' => \App\Role::TYPE_ADMIN ];

	    DB::table( 'user_roles' )->truncate();
	    foreach ($data as $item) {
		    DB::table( 'user_roles' )->insert(
			    [
				    'user_id'    => $item['user_id'],
				    'role_id'    => $item['role_id'],
				    'active'     => 1,
				    'created_at' => \Carbon\Carbon::now(),
				    'updated_at' => \Carbon\Carbon::now()
			    ]
		    );
	    }
    }
}
