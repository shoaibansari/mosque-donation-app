<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SettingsTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		$settings = array(

			#/ App Info
			'app.name'            => ['Site Name', 'ValueLogoDesign'],
			'app.version'         => ['Version', '1.0.0'],
			'app.installation_at' => ['Installation Date', \Carbon\Carbon::now()],

			#/ Client Info
			'first_name'          => ['First Name', 'ValueLogoDesign'],
			'last_name'           => ['Last Name', ''],
			'address'           => ['Address / Location', '1401 N. Central Expressway, Suite 100 Richardson, Texas 75080, United States'],
			'email.personal'      => ['Email', 'adnan@fsdsolutions.com'],
			'email.info'          => ['Email - Info', 'info@valuelogodesign.com'],
			'email.support'       => ['Email - Support', 'support@valuelogodesign.com'],
			'email.no_reply'      => ['Email - No Reply', 'no-reply@valuelogodesign.com'],
			'email.sales'         => ['Email - Sales', 'sales@valuelogodesign.com'],
			'phone.plain'         => ['Phone Plain', '+0012145503360'],
			'phone.formatted'     => ['Phone Formatted', '+01-214-550-3360'],
			'phone2.plain'        => ['Phone 2 Plain', ''],
			'phone2.formatted'    => ['Phone 2 Formatted', ''],

			#/ Urls
			'backend.admin.base' => ['Admin Login Base', 'backoffice/978/'],
			'app_url'            => ['App URL', env('APP_URL', 'http://'. preg_replace('@^http://@i', '', env( 'APP_URL' )) )],
			'secure_url'         => ['Secure URL', env('SECURE_URL', 'https://'. preg_replace('@^http(s)?://@i', '', env( 'APP_URL' )) )],

			#/ Theme Settings
			'theme.frontend' => ['Theme - Frontend', 'default'],
			'theme.backend'  => ['Theme - Backoffice', 'default'],

			#/ Time Settings
			'timezone.name'   => ['Timezone Name', 'GMT'],
			'timezone.offset' => ['Timezone Offset', '0'],

			#/ Date & Time Formats
			'time.format.short' => ['Time Format - Short', 'h:i A'],
			'time.format.long'  => ['Time Format - Long', 'h:i:s A'],
			'time.format.full'  => ['Time Format - Full', 'h:i:u A'],
			'date.format.short' => ['Date Format - Short', 'm/d/Y'],
			'date.format.long'  => ['Date Format - Long', 'F d, Y'],
			'date.format.full'  => ['Date Format - Full', 'D, F d, Y'],

			#/ Languages
			'language.default'    => ['Language', 'EN-US'],
			'supported.languages' => ['Supported Languages', 'EN-US'],

			#/ Currency
			'primary.currency'          => ['Primary Currency', 'USD'],
			'primary.currency.symbol'   => ['Primary Currency Symbol', '$ '],

			#/ Vendor Info
			'vendor.name'           => ['Vendor Name', 'ValueLogoDesign'],
			'vendor.url'            => ['Vendor URL', 'http://www.valuelogodesign.com'],

			#/ Error Reporting
			'on_error.send_email'    => ['On Error Send Email', '1'],
			'on_error.email'         => ['On Error Send Email To', 'adnan@fsdsolutions.com'],
			'on_error.email.subject' => ['On Error Email Subject', 'adnan@fsdsolutions.com'],
		);

		DB::table('settings')->truncate();
		foreach ( $settings as $key => $value ) {
			DB::table('settings')->insert([ 'key' => $key, 'label' => $value[0], 'value' => $value[1]] );
		}

	}

}
