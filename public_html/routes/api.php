<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api', 'middleware' => 'api'], function() {

	// Auth
	Route::post('signup', 'AuthController@signup');
	Route::post('login', 'AuthController@login');
	Route::post('forgot-password', 'AuthController@forgotPassword');
    // Route::post('account', 'AuthController@account');

    //Mosque
    Route::post('masjid/create', 'MosqueController@store');

	Route::group(['middleware' => 'api.auth'], function() {
	    Route::post('logout', 'AuthController@logout');
	});
	
	// Others
	Route::group(['middleware' => 'api.auth'], function() {
		Route::post('user', 'UserController@getUser');
        Route::post('account', 'UserController@updateProfile');

        //Mosque
        Route::post('masjid', 'MosqueController@getMosque');
        Route::post('masjid/list', 'MosqueController@getAllMosque');

        //donations
        Route::post('masjid/donation', 'MosqueDonationController@store');
        Route::post('masjid/donation/detail', 'MosqueDonationController@view');
        Route::post('past/donation', 'MosqueDonationController@getPastDonation');

        //mosque donation
        Route::post('masjid/donation/list', 'DonationController@getMosqueDonation');

        //Nearby mosque
        Route::post('masjid/nearby', 'MosqueController@searchMosque');

        //Prayer Time
        Route::post('salat', 'PrayerTimeController@getPrayerTime');

        //wallet
        Route::post('wallet', 'UserAccountController@store');

    });
	
});
