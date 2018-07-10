<?php
/*
|--------------------------------------------------------------------------
| Debug Controller
|--------------------------------------------------------------------------
|
|
*/
if( env('APP_DEBUG') ) {

	/*
	|--------------------------------------------------------------------------
	| Log database queries in log file.
	|--------------------------------------------------------------------------
	|
	*/
	
	
//	\Event::listen(
//		'Illuminate\Database\Events\QueryExecuted', function($query) {
//		Log::info(
//			print_r(
//				[
//					'SQL'      => $query->sql,
//					'Bindings' => $query->bindings,
//					'Time'     => $query->time,
//				], true
//			) . PHP_EOL
//		);
//	});
	
	Route::get('debug/email', 'TestController@testEmail');
	
	Route::get(
		'/password-hash/{password}', function($pass) {
		// The default password: Xabcd-1234
		echo '<code>Password: ' . $pass . '<br>Hash: ' . bcrypt($pass) . '</code>';
		
	});
	
}

/*Route::get('/pdf', function () {

   

});
*/

/*
|--------------------------------------------------------------------------
| Frontend
|--------------------------------------------------------------------------
|
|
*/

Route::group([ 'namespace' => 'Frontend'], function () {


	Route::get( '/', 'PageController@homePage' )->name( 'home' );

	# session checker
	Route::get('session/alive', function() {
		return ['expired' => auth()->check() ? 'no' : 'yes' ];
	})->name('check.session');

	# login
	Route::get( 'login', 'Auth\LoginController@showLoginForm' )->name( 'login.request' );
	Route::post( 'login', 'Auth\LoginController@login' )->name( 'login' );
	Route::get( 'logout', 'Auth\LoginController@logout' )->name( 'logout' );

	# Password Reset
	Route::get( 'password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm' )->name( 'password.request' );
	Route::post( 'password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail' )->name( 'password.email' );
	Route::get( 'password/reset/{email}/{token}', 'Auth\ResetPasswordController@showResetForm' )->name( 'password.reset' );
	Route::post( 'password/reset', 'Auth\ResetPasswordController@reset' )->name( 'password.sendLink' );

	# Registration
	//Route::get( 'signup', 'Auth\RegisterController@showRegistrationForm' )->name( 'signup.request' );
	Route::post( 'signup', 'Auth\RegisterController@register')->name('signup');
	Route::get( 'signup/email/verification/{code}', 'Auth\RegisterController@confirmation')->name('signup.confirmation');

	# Serving uploaded files
	Route::get( 'uploads/{filename}', 'FileController@serve' )->where( 'filename', '.*' );

});


/*
|--------------------------------------------------------------------------
| Routes under user authentication
|--------------------------------------------------------------------------
|
|
*/
Route::group(['middleware' => 'auth', 'namespace'=> 'UsersArea'], function () {

	# Dashboard
	Route::get( 'dashboard', 'DashboardController@index' )->name( 'dashboard' );

	# Profile
	Route::post( 'profile', 'UserController@postProfile' )->name( 'profile.update' );
	Route::get( 'profile', 'UserController@getProfile' )->name( 'profile.edit' );
	Route::post( 'profile/password', 'UserController@postChangePassword' )->name( 'password.update' );
	Route::get( 'profile/remove/avatar', 'UserController@getRemoveAvatar' )->name( 'remove.avatar' );
	
	# Donation
	Route::get( 'donation', 'DonationController@manage' )->name( 'donation.manage' );
	Route::get( 'donation/create', 'DonationController@create' )->name( 'donation.create' );
	Route::post( 'donation/store', 'DonationController@store' )->name( 'donation.store' );
	Route::get( 'donation/edit/{id}', 'DonationController@edit' )->name( 'donation.edit' );
	Route::post( 'donation/update', 'DonationController@update' )->name( 'donation.update' );
	Route::get( 'donation/delete/{id}', 'DonationController@delete' )->name( 'donation.delete' );
	Route::get( 'donation/view/{id}', 'DonationController@view' )->name( 'donation.view' );
	
	# Mosque
	Route::get( 'mosque', 'MosqueController@manage' )->name( 'mosque.manage' );
	Route::get( 'mosque/edit/{id}', 'MosqueController@edit' )->name( 'mosque.edit' );
	Route::post( 'mosque/update', 'MosqueController@update' )->name( 'mosque.update' );

	# Settings
	Route::get( 'settings', 'SettingController@getSettings' )->name( 'settings.edit' );
	Route::post( 'settings', 'SettingController@postSettings' )->name( 'settings.update' );

	# Settings > countries
	Route::get( 'settings/countries', 'SettingController@getCountries' )->name( 'settings.countries' );
	Route::post( 'settings/countries/status', 'SettingController@postCountryStatus' )
		->name( 'settings.countries.status' );

});



/*
|--------------------------------------------------------------------------
| Backoffice
|--------------------------------------------------------------------------
|
|
*/
Route::group( [ 'as' => 'admin.', 'prefix' => settings()->getAdminBase(), 'namespace' => 'Backoffice'  ] , function (){


	/*
	|--------------------------------------------------------------------------
	| Admin Auth
	|--------------------------------------------------------------------------
	|
	|
	*/

	# session checker
	Route::get('session/alive', function() {
		return ['expired' => auth('admin')->check() ? 'no' : 'yes' ];
	})->name('check.session');

    # login
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login')->name('do.login');
    Route::get('logout', 'Auth\LoginController@logout')->name( 'logout' );

    # Password Reset
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
	Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name( 'password.sendLink' );

    # Registration
    Route::get('signup', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm'])->name('signup.request');
    Route::post('signup', [ 'as' => '', 'uses' => 'Auth\RegisterController@signup']);

	/*
	|--------------------------------------------------------------------------
	| Routes under admin authentication
	|--------------------------------------------------------------------------
	|
	|
	*/
	Route::group( [ 'middleware' => 'admin.auth'  ] , function () {

		# Dashboard
		Route::get( 'dashboard', 'DashboardController@index' )->name( 'dashboard' );

		# Admin Profile
		Route::get( 'profile', 'AdminController@getProfile' )->name( 'edit' );
		Route::post( 'profile', 'AdminController@postProfile' )->name( 'update' );
		Route::post( 'profile/password', 'AdminController@postChangePassword' )->name( 'password.update' );
		Route::get( 'profile/remove/avatar', 'AdminController@getRemoveAvatar' )->name( 'remove.avatar' );

		
		# Area Locations
		Route::get( 'area/location/create', 'AreaLocationController@create' )->name( 'area.location.create' );
		Route::post( 'area/location/store', 'AreaLocationController@store' )->name( 'area.location.store' );
		Route::get( 'area/location/edit/{area_id}/{location_id}', 'AreaLocationController@edit' )->name( 'area.location.edit' );
		Route::post( 'area/location/update', 'AreaLocationController@update' )->name( 'area.location.update' );
		Route::get( 'area/location/delete/{area_id}/{location_id}', 'AreaLocationController@delete' )->name( 'area.location.delete' );
		Route::get('area/list/{fieldName}', 'AreaLocationController@apiList')->name('areas.list');

		# Donation
		Route::get( 'donation', 'DonationController@manage' )->name( 'donation.manage' );
		Route::get( 'donation/create', 'DonationController@create' )->name( 'donation.create' );
		Route::post( 'donation/store', 'DonationController@store' )->name( 'donation.store' );
		Route::get( 'donation/edit/{id}', 'DonationController@edit' )->name( 'donation.edit' );
		Route::post( 'donation/update', 'DonationController@update' )->name( 'donation.update' );
		Route::get( 'donation/delete/{id}', 'DonationController@delete' )->name( 'donation.delete' );
		Route::get( 'donation/view/{id}', 'DonationController@view' )->name( 'donation.view' );



		# Mosque
		Route::get( 'mosque', 'MosqueController@manage' )->name( 'mosque.manage' );
		Route::get('mosque/view/{id}', 'MosqueController@view')->name('mosque.view');
		Route::get( 'mosque/delete/{id}', 'MosqueController@delete' )->name( 'mosque.delete' );
		Route::get( 'mosque/create', 'MosqueController@create' )->name( 'mosque.create' );
		Route::post( 'mosque/store', 'MosqueController@store' )->name( 'mosque.store' );
		Route::get( 'mosque/edit/{id}', 'MosqueController@edit' )->name( 'mosque.edit' );
		Route::post( 'mosque/update', 'MosqueController@update' )->name( 'mosque.update' );
		Route::post('mosque/import/homeowners', 'MosqueController@importHomeOwners')->name('jobs.import.homeowners');
		Route::post('mosque/completed', 'MosqueController@completed')->name('mosque.completed');

		# Settings
		Route::get( 'settings', 'SettingController@getSettings' )->name( 'settings.edit' );
		Route::post( 'settings', 'SettingController@postSettings' )->name( 'settings.update' );

		# Settings > countries
		Route::get( 'settings/countries', 'SettingController@getCountries' )->name( 'settings.countries' );
		Route::post( 'settings/countries/status', 'SettingController@postCountryStatus' )->name( 'settings.countries.status' );

		# Users
		Route::get( 'users', 'UserController@manage' )->name( 'users.manage' );
		Route::post( 'users/block', 'UserController@block' )->name( 'users.blocked' );
		Route::post( 'users/confirm', 'UserController@confirm' )->name( 'users.confirmed' );
		Route::get( 'users/delete/{id}', 'UserController@delete' )->name( 'users.delete' );
		Route::get( 'users/create', 'UserController@create' )->name( 'users.create' );
		Route::post( 'users/store', 'UserController@store' )->name( 'users.store' );
		Route::get( 'users/edit/{id}', 'UserController@edit' )->name( 'users.edit' );
		Route::post( 'users/update', 'UserController@update' )->name( 'users.update' );
				

		# Pages
		Route::get( 'pages', 'PageController@index' )->name( 'pages.manage' );
		Route::post( 'pages/data', 'PageController@postManageData' )->name( 'pages.data' );
		Route::post('pages/publish/status', 'PageController@postPublishStatus')->name('pages.publish');
		Route::post( 'pages/store', 'PageController@store' )->name( 'pages.store' );
		Route::get( 'pages/edit/{id}', 'PageController@edit' )->name( 'pages.edit' );
		Route::post( 'pages/update', 'PageController@update' )->name( 'pages.update' );
		Route::get( 'pages/delete/{id}', 'PageController@delete' )->name( 'pages.delete' );

		# Menus
		Route::get( 'menus', 'MenuController@index' )->name( 'menus.manage' );
		Route::post( 'menus/status', 'MenuController@postActiveStatus' )->name( 'menus.status' );
		Route::post( 'menus/sort/items', 'MenuController@postSortItems' )->name( 'menus.sort.items' );
		Route::get( 'menus/create/{menu_id}', 'MenuController@create' )->name( 'menus.create' );
		Route::post( 'menus/store', 'MenuController@store' )->name( 'menus.store' );
		Route::get( 'menus/edit/{id}', 'MenuController@edit' )->name( 'menus.edit' );
		Route::post( 'menus/update', 'MenuController@update' )->name( 'menus.update' );
		Route::get( 'menus/delete/{id}', 'MenuController@delete' )->name( 'menus.delete' );
		

	});

});



/*
|--------------------------------------------------------------------------
| All other pages
|--------------------------------------------------------------------------
|
|
*/
Route::get( '{slug}', 'Frontend\PageController@getPageBySlug' )->where( 'slug', '.*' );