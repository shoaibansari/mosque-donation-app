<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Repositories\Eloquent\MenuRepository;
use App\Models\Repositories\Eloquent\SocialLinkRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
	
	    /*
		|--------------------------------------------------------------------------
		| Custom Validation Rules
		|--------------------------------------------------------------------------
		|
		*/
	    if(env('APP_DEBUG')) {
		    DB::connection()->enableQueryLog();
	    }


	    /*
		|--------------------------------------------------------------------------
		| Custom Validation Rules
		|--------------------------------------------------------------------------
		|
		*/
	    Validator::extend('recaptcha', 'App\\Validators\\Recaptcha@validate' );


		/*
		|--------------------------------------------------------------------------
		| Global data for frontend views
		|--------------------------------------------------------------------------
		|
		*/
	    $menus = MenuRepository::instance()->getMenus();
        //$socialLinks = SocialLinkRepository::instance()->getAllActive();
        //dump( $menus, request()->path() );

    	View::share( compact('menus') );


	    /*
		|--------------------------------------------------------------------------
		| Global data for backoffice views
		|--------------------------------------------------------------------------
		|
		*/

	    #/ if user role is admin then associating "admin" model with $thisUser variable
        view()->composer(toolbox()->backend()->view('*'), function ($view) {
        	if ( auth('admin')->check() ) {
	            $view->with( 'thisUser', auth('admin')->user() );
            } else {
	            $view->with( 'thisUser', auth()->user() );
            }
        });


        #/ For User Area
	    view()->composer( toolbox()->userArea()->view( '*' ), function ( $view ) {
			    $view->with( 'thisUser', auth()->user() );
	    });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

//    	# adnan: custom block //
//	    $this->app->bind(
//		    'path.public', function () {
//		    return base_path();
//	    });
//	    #//

    }
}
