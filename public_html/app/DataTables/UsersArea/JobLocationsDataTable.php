<?php

namespace App\DataTables\UsersArea;

use App\Models\Admin;
use App\Models\Role;
use App\Models\Job;
use App\Models\JobLocation;
use Carbon\Carbon;
use Yajra\Datatables\Services\DataTable;
use Illuminate\Support\Facades\DB;

class JobLocationsDataTable extends DataTable
{
	
	/**
	 * Display ajax response.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
    public function ajax()
    {
        return $this->datatables->eloquent($this->query())
	        ->addColumn(
		        'id', function($location) {
		        return $location->location_id;
	        })
	        ->addColumn(
                'address', function ($location) {
                
                return
	                '<a href="'. route('jobs.location.view', [$location->job_id, $location->location_id] ) .'">' .
	                $location->address
	                . '</a><br>'
	                . '<small><em>'
	                . $location->homeOwner->name
		            . '<br>'
	                . $location->homeOwner->email
	                . '</em></small>';
            })
            ->addColumn(
                'is_completed', function ($location ) {
                return ($location->is_completed ? 'Yes' : 'No');
            })
            ->addColumn(
                'created_at', function ($location ) {
                return toolbox()->datetime()->formatShortDateTimeFormat($location->created_at);
            })
	        ->addColumn(
		        'updated_at', function($location) {
		        return toolbox()->datetime()->formatShortDateTimeFormat($location->updated_at);
	        })
            ->addColumn('action', function($location) {
            	$area_id = request()->route('id');
                return '
                    <button type="button" class="btn bg-blue waves-effect btn-xs btn-view" title="View" data-area-id="' . $area_id . '" data-location-id="'. $location->location_id .'">View</button>
                ';
            })
            ->rawColumns(['address'])
            ->make(true);
    }


    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Job::find( request()->route('job_id') )->locations();
        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->ajax('')
                    //->addAction(['width' => '75px'])
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'address',
            'is_completed',
            'created_at' => ['title' => 'Date Created'],
            'updated_at' => ['title' => 'Last Update'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'backoffice\pagesdatatables_' . time();
    }


    /**
     * Get default builder parameters.
     *
     * @return array
     */
    protected function getBuilderParameters()
    {
        return [
	        'dom' => "<'row'<'col-md-8 col-sm-8'l><'col-md-4 col-sm-4'f>><'table-scrollable't><r><'row'<'col-md-5 col-sm-5'i><'col-md-7 col-sm-7'p>>",
            'order'   => [[0, 'asc']],
//            'buttons' => [
//                'create',
//                'export',
//                'print',
//                'reset',
//                'reload',
//            ],
        ];
    }

}
