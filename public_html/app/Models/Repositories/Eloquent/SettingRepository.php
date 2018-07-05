<?php
/**
 * Created by Muhammad Adnan
 * Created Time: 11/23/2017 4:54 AM
 */

namespace App\Models\Repositories\Eloquent;

use App\Models\Repositories\SettingRepositoryInterface;
use App\Models\Settings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SettingRepository extends AbstractRepository implements SettingRepositoryInterface {

	public function __construct( Settings $settings ) {
		parent::__construct( $settings );

		if ( !Schema::hasTable( 'settings' ) ) {
			\Log::error( '"settings" table is missing.' );
			if ( app()->runningInConsole() ) {
				return false;
			}
			throw new \Exception( "App settings not found." );
		}
	}

	public static function instance( $key = null, $column = 'value' ) {
		static $instance;
		if ( !$instance ) {
			$instance = new SettingRepository ( new Settings() );
		}
		if ( !is_null( $key ) ) {
			return $instance->item( $key, $column );
		}

		return $instance;
	}

	public function getForListing() {
		if ( !$items = $this->getModel()->visible()->orderBy( 'display_order' )->get() ) {
			return false;
		}

		return $items->groupBy('type');

	}


	public function all( $key = null, $object=true ) {
		static $settings;

		if ( !$settings ) {

			$collection = $this->getModel()->orderBy('type')->orderBy('display_order')->get()->toArray();

			if ( $collection ) {
				foreach ( $collection as $item ) {
					$settings[ $item[ 'key' ] ] = $item;
				}
			}
		}

		if ( !$settings || !is_array( $settings ) ) {
			return null;
		}

		if ( !is_null( $key ) ) {
			return array_key_exists( $key, $settings ) ? $settings[ $key ] : null;
		}

		if ( $object ) {
			return json_decode( json_encode($settings) );
		}
		return $settings;
	}

	public function item( $key, $column = 'value' ) {

		if ( !$item = $this->all( $key ) ) {
			return null;
		}

		if ( !is_null( $column ) ) {
			if ( array_key_exists( $column, $item ) ) {
				return $item[ $column ];
			}
			return null;
		}

		return $item;
	}
	
	/**
	 * Get assets base url
	 *
	 * @return string
	 */
	public function getAssetsBaseUrl() {
		if(env('APP_ASSETS_URL')) {
			return rtrim(env('APP_ASSETS_URL'), '/');
		}
		
		return rtrim(url(''), '/');
	}

	/*
	|--------------------------------------------------------------------------
	| App Info
	|--------------------------------------------------------------------------
	*/

	public function getAppName() {
		return $this->item( 'app.name' );
	}

	public function getAppVersion() {
		return $this->item( 'app.version' );
	}

	public function getInstallationDate() {
		return $this->item( 'app.installation_at' );
	}

    /*
    |--------------------------------------------------------------------------
    | Update Info
    |--------------------------------------------------------------------------
    */

    public function updateSettings($data){
        var_dump($data);
        $setting = new Settings;
        foreach( $data as $key => $value ) {
            $key = str_replace('_', '.', $key );


            if ( !$model = Settings::where('key', $key )->first() ) {
                continue;
            }
            $model->value = $value;
            $model->save();
        }

        return true;
    }

	/*
	|--------------------------------------------------------------------------
	| Client Info
	|--------------------------------------------------------------------------
	*/

	public function getClientFirstName() {
		return trim( $this->item( 'client.first_name' ) );
	}

	public function getClientLastName() {
		return trim( $this->item( 'client.last_name' ) );
	}

	public function getClientFullName() {
		return implode(
			" ", [
				   $this->getClientFirstName(),
				   $this->getClientLastName()
			   ]
		);
	}

	public function getClientEmail() {
		return $this->item( 'client.email' );
	}

	public function getAdminEmail() {
		return $this->getClientEmail();
	}

	public function getAdminName() {
		return $this->getClientFullName();
	}

	public function getPhone1() {
		return $this->item( 'client.phone1' );
	}

	public function getPhone2() {
		return $this->item( 'client.phone2' );
	}

	public function getInfoEmailAddress() {
		return $this->item( 'email.info' );
	}

	public function getSupportEmailAddress() {
		return $this->item( 'email.support' );
	}

	public function getNoReplyEmailAddress() {
		return $this->item( 'email.no_reply' );
	}

	/*
	|--------------------------------------------------------------------------
	| URLs
	|--------------------------------------------------------------------------
	*/
	public function getUrl( $secure = false ) {
		return $secure ? $this->getSecureUrl() : trim( env('APP_URL', $this->item( 'app_url' )) );
	}

	public function getSecureUrl() {
		return trim( env('APP_SECURE_URL', $this->item( 'secure_url' ) )) ;
	}

	public function getAdminBase( $path = "" ) {
		return trim( $this->item( 'backend.admin.base' ), "/" ) . $path;
	}

	public function getAdminUrl( $path = "", $secure = false ) {
		$url = rtrim( $this->getUrl( $secure ), "/" ) . "/" . trim( $this->item( 'backend.admin.base' ), "/" ) . "/";
		if ( trim( $path ) ) {
			$url .= trim( $path, "/" ) . "/";
		}

		return $url;
	}

	/*
	|--------------------------------------------------------------------------
	| Themes
	|--------------------------------------------------------------------------
	*/

	public function getFrontendTheme() {
		return $this->item( 'theme.frontend' );
	}

	public function getAdminTheme() {
		return $this->item( 'theme.backend' );
	}

	/*
	|--------------------------------------------------------------------------
	| Time Settings
	|--------------------------------------------------------------------------
	*/

	public function getTimezone() {
		return $this->item( 'timezone.name' );
	}

	public function getTimezoneOffset() {
		return $this->item( 'timezone.offset' );
	}

	/*
	|--------------------------------------------------------------------------
	| Data & Time Formats
	|--------------------------------------------------------------------------
	*/

	public function getShortTimeFormat() {
		return $this->item( 'time.format.short' );
	}

	public function getLongTimeFormat() {
		return $this->item( 'time.format.long' );
	}

	public function getFullTimeFormat() {
		return $this->item( 'time.format.full' );
	}

	public function getShortDateFormat() {
		return $this->item( 'date.format.short' );
	}

	public function getLongDateFormat() {
		return $this->item( 'date.format.long' );
	}

	public function getFullDateFormat() {
		return $this->item( 'date.format.full' );
	}

	public function getShortDateTimeFormat() {
		return $this->getShortDateFormat() . ' ' . $this->getShortTimeFormat();
	}

	public function getLongDateTimeFormat() {
		return $this->getLongDateFormat() . ' ' . $this->getLongTimeFormat();
	}

	public function getFullDateTimeFormat() {
		return $this->getFullDateFormat() . ' ' . $this->getFullTimeFormat();
	}

	/*
	|--------------------------------------------------------------------------
	| Languages
	|--------------------------------------------------------------------------
	*/

	public function getLanguage() {
		return $this->item( 'language' );
	}

	public function getSupportedLanguages() {
		$lang = $this->item( 'supported.languages' );
		if ( empty( $lang ) ) {
			return null;
		}

		return explode( ",", $lang );
	}

	/*
	|--------------------------------------------------------------------------
	| Currency
	|--------------------------------------------------------------------------
	*/

	public function getPrimaryCurrency() {
		return $this->item( 'primary.currency' );
	}

	public function getPrimaryCurrencySymbol() {
		return $this->item( 'primary.currency.symbol' );
	}

	public function getSecondaryCurrency() {
		return $this->item( 'secondary.currency' );
	}

	public function getSecondaryCurrencySymbol() {
		return $this->item( 'secondary.currency.symbol' );
	}

	public function getCurrencyExchangeRate() {
		return $this->item( 'currency.exchange.rate' );
	}

	/*
	|--------------------------------------------------------------------------
	| Vendor Info
	|--------------------------------------------------------------------------
	*/

	public function getVendorName() {
		return $this->item( 'vendor.name' );
	}

	public function getVendorUrl() {
		return $this->item( 'vendor.url' );
	}

	/*
	|--------------------------------------------------------------------------
	| Error Reporting
	|--------------------------------------------------------------------------
	*/

	public function isSendEmailOnError() {
		$e = $this->item( 'on_error.send_email' );

		return !empty( $e );
	}

	public function getOnErrorEmailAddress() {
		return $this->item( 'on_error.email' );
	}

	public function getOnErrorEmailSubject() {
		return $this->item( 'on_error.email.subject' );
	}

}