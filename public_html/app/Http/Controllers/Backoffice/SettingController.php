<?php

namespace App\Http\Controllers\Backoffice;


use App\Http\Controllers\Controller;

use App\Models\Repositories\Eloquent\SettingRepository;
use App\DataTables\Backoffice\CountriesDataTable;
use Illuminate\Http\Request;
use App\Models\Repositories\Eloquent\CountryRepository;

class SettingController extends Controller
{
	protected
		$settingRepo,
		$countryRepo
	;

	public function __construct(
		SettingRepository $settingRepository,
		CountryRepository $countryRepository
		 )
	{
		$this->settingRepo = $settingRepository;
		$this->countryRepo = $countryRepository;
	}

	public function getSettings() {
		$settings = $this->settingRepo->getForListing();
		return view( toolbox()->backend()->view( 'settings.general' ), compact('settings') );
	}

	public function postSettings(Request $request ) {
        $settings = $this->settingRepo;
        $data = $request->except(['_token']);
        if ( !$settings->updateSettings($data) ) {
            return redirect()->back()->with( 'error','' );
        }

        return redirect()->back()
            ->with('success', $settings->getData('success') )
            ->with('details', $settings->getData('details') );
	}

	public function getCountries( CountriesDataTable $dataTable ) {
		toolbox()->pluginsManager()->plugins(['datatables']);
		return $dataTable->render( toolbox()->backend()->view( 'settings.countries' ) );
	}

	public function postCountryStatus( Request $request ) {

		if ( !$country = $this->countryRepo->findById( $request->id ) ) {
			abort( 404, 'Country not found' );
		}
		$country->active = $request->status ? 1 : 0;

		$country->save();

		return toolbox()->response()->success( 'Country status has been updated.' )->send();
	}


}
