<?php

use Illuminate\Database\Seeder;

class UserTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $data = \App\UserType::getSeedData();
	    $seeds = [];
	    foreach( $data as $id => $item ) {
		    $seeds[] = [
			    'id' => $id,
			    'title' => $item,
			    'active' => 1,
			    'created_at' => \Carbon\Carbon::now(),
			    'updated_at' => \Carbon\Carbon::now()
		    ];
	    }
	    DB::table('user_types')->truncate();
	    DB::table('user_types')->insert( $seeds );
    }
}
