<?php
/**
 * Created by PhpStorm.
 * User: Muhammad Adnan
 * Date: 11/26/2016
 * Time: 5:58 AM
 */

namespace App\Classes\CToolBox;

use Carbon\Carbon;

class CDateTimeTool {

	/**
	 * @return CDateTimeTool
	 */
	public static function instance() {
		static $instance;
		if (!$instance) {
			$instance = new CDateTimeTool();
		}

		return $instance;
	}


	/**
	 * Convert time from UTC to user specified timezone
	 *
	 * @param $format
	 * @param $date
	 * @param null $timezone
	 * @return string
	 */
	public function format( $format, $date, $timezone=null ) {
		return $this->parse( $date, $timezone)->format( $format );
	}

	#/ Time

	public function formatShortTimeFormat( $input, $timeZone=null) {
		return $this->format( settings()->getShortTimeFormat(), $input, $timeZone );
	}

	public function formatLongTimeFormat( $input, $timeZone = null ) {
		return $this->format( settings()->getLongTimeFormat(), $input, $timeZone );
	}

	public function formatFullTimeFormat( $input, $timeZone = null ) {
		return $this->format( settings()->getFullTimeFormat(), $input, $timeZone );
	}

	#/ Date

	public function formatShortDateFormat( $input, $timeZone = null ) {
		return $this->format( settings()->getShortDateFormat(), $input, $timeZone );
	}

	public function formatLongDateFormat( $input, $timeZone = null ) {
		return $this->format( settings()->getLongDateFormat(), $input, $timeZone );
	}

	public function formatFullDateFormat( $input, $timeZone = null ) {
		return $this->format( settings()->getFullDateFormat(), $input, $timeZone );
	}

	#/ DateTime

	public function formatShortDateTimeFormat( $input, $timeZone = null ) {
		return $this->format( settings()->getShortDateTimeFormat(), $input, $timeZone );
	}

	public function formatLongDateTimeFormat( $input, $timeZone = null ) {
		return $this->format( settings()->getLongDateTimeFormat(), $input, $timeZone );
	}

	public function formatFullDateTimeFormat( $input, $timeZone = null ) {
		return $this->format( settings()->getFullDateTimeFormat(), $input, $timeZone );
	}
	
	
	public function formatCompact($input, $timeZone = null) {
		$time = $this->parse($input, $timeZone);
		if ( $time->isToday() ) {
			return $time->format('h:i A');
		}
		else if( $time->isCurrentYear() ) {
			return $time->format('M j');
		}
		else {
			return $time->format('M j, Y');
		}
	}

	#/ Utilities

	/**
	 * Get carbon instance
	 *
	 * @param $dateTime
	 * @param $timezone null
	 * @return Carbon
	 */
	public function parse( $dateTime, $timezone=null) {
		$dt = Carbon::parse( $dateTime, config( 'app.timezone' ) );
		if ( !$timezone ) {
			if ( $timezone = env( 'APP_TIMEZONE', settings()->getTimezone() ) ) {
				$dt->setTimezone( $timezone );
			}
		} else {
			$dt->setTimezone( $timezone );
		}
		return $dt;
	}


	// TODO:: not tested
	public function toUTC( $value, $tz=null ) {

		if ( empty($value) || $value == '0000-00-00' || $value == '0000-00-00 00:00:00' ) {
			return null;
		}

		$tz = $tz ? $tz : env('TIMEZONE');
		if ($value instanceof Carbon) {
			return $value->setTimezone('UTC')->toDateTimeString();
		}

		// mm/dd/yyyy
		if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $value)) {
			return Carbon::createFromFormat('m/d/Y', $value, $tz)
				->setTimezone('UTC')->toDateTimeString();
		}

		// mm/dd/yyyy H:i
		if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})/', $value)) {
			return Carbon::createFromFormat('m/d/Y H:i', $value, $tz)
				->setTimezone('UTC')->toDateTimeString();
		}

		// 0000-00-00 00:00:00
		if (preg_match('/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/', $value)) {
				return Carbon::createFromFormat('Y-m-d H:i|', $value, $tz)
					->setTimezone('UTC')->toDateTimeString();
		}

		return Carbon::createFromFormat('Y-m-d H:i|+', $value, $tz)
			->setTimezone('UTC')->toDateTimeString();

	}

	/**
	 * @param bool $formatted
	 * @param null $format
	 * @return string
	 */
	public function currentDate( $formatted=true, $format=null ) {
		if ( !$formatted ) {
			return date('Y-m-d');
		}
		return $this->format( is_null( $format ) ? settings()->getShortDateFormat() : $format, date( 'Y-m-d') );
	}

	/**
	 * @param bool $twoDigits
	 * @return false|string
	 */
	public function currentYear( $twoDigits=false ) {
		return date( $twoDigits ? 'y': 'Y');
	}


	/**
	 *
	 */
	public function getUSTimeZones() {
		return [
			'America/New_York'    => 'Eastern Time',
			'America/Chicago'     => 'Central Time',
			'America/Denver'      => 'Mountain Time',
			//'America/Phoenix'     => 'Mountain Time',   // No DST
			'America/Los_Angeles' => 'Pacific Time',
			'America/Anchorage'   => 'Alaska Time',
			'America/Adak'        => 'Hawaii-Aleutian',
			'Pacific/Honolulu'    => 'Hawaii-Aleutian Time'
		];
	}


}