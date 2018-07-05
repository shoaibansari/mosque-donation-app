<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$data = \App\Permission::getSeedData();
	    $seed = [];
	    foreach ( $data as $item) {
	    	list($permission_label_id, $permission_id, $title) = $item;
			$seed[] = [
				'id'                  => $permission_id,
				'permission_group_id' => $permission_label_id,
				'title'               => $title,
				'active'              => 1,
				'created_at'          => \Carbon\Carbon::now(),
				'updated_at'          => \Carbon\Carbon::now()
			];
	    }
	    DB::table( 'permissions' )->truncate();
	    DB::table( 'permissions' )->insert( $seed );
    }


}
