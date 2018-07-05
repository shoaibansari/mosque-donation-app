<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    // ************************************
	    // Creating users (owner|staff)
	    // ************************************
	    $users = [

		    // Owner
		    [
			    'user_type_id' => \App\UserType::TYPE_OWNER,
			    'name' => 'Muhammad Adnan',
			    'email' => 'owner@fsdsolutions.com',
			    'password' => bcrypt('abcd#1234'),
			    'active' => '1',
			    'phone1'     => '',
			    'phone2'     => '',
			    'address1'   => '',
			    'address2'   => '',
			    'city'       => 'Dallas',
			    'state'      => 'TX',
			    'country'    => 'US',
			    'timezone'   => '-5',
			    'created_at' => \Carbon\Carbon::now(),
			    'updated_at' => \Carbon\Carbon::now(),
			],

		    // Admin
		    [
			    'user_type_id' => \App\UserType::TYPE_STAFF,
			    'name' => 'Muhammad Adnan',
			    'email'    => 'adnan@fsdsolutions.com',
			    'password' => bcrypt( 'abcd#1234' ),
			    'active'   => '1',
			    'phone1'     => '',
			    'phone2'     => '',
			    'address1'   => '',
			    'address2'   => '',
			    'city'       => 'Karachi',
			    'state'      => 'Sindh',
			    'country'    => 'PK',
			    'timezone'   => '+5',
			    'created_at' => \Carbon\Carbon::now(),
			    'updated_at' => \Carbon\Carbon::now(),
		    ]
		];

		DB::table('users')->truncate();
	    DB::table('users')->insert( $users );
//
//	    // ************************************
//	    // Creating Clients
//	    // ************************************
//	    $data = [
//		    [
//			    "name"     => 'FSD Solutions',
//			    "email"    => "info@fsdsolutions.com",
//			    "password" => "abcd#1234",
//			    "active"   => 1
//
//		    ],
//	    ];
//	    foreach( $data as $item ) {
//		    $client = new \App\Client();
//		    $client->name = $item['name'];
//		    $client->email = $item['email'];
//		    $client->password = bcrypt( $item['password'] );
//		    $client->active = $item['active'];
//		    $client->save();
//	    }
    }
}
