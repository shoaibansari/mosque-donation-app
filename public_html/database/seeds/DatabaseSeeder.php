<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

	    DB::statement( 'SET FOREIGN_KEY_CHECKS=0;' );

        $this->call(SettingsTableSeeder::class);

        $this->call(CountriesTableSeeder::class);
        $this->call(EmailTemplateSettingsSeeder::class);
        $this->call(EmailTemplatesSeeder::class);

        $this->call(PermissionGroupsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RolePermissionsTableSeeder::class);
        $this->call(UserTypesTableSeeder::class);

        $this->call(UsersTableSeeder::class);

	    DB::statement( 'SET FOREIGN_KEY_CHECKS=1;' );

    }
}
