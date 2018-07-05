<?php

namespace App\DataTables\UsersArea;

use App\Models\Repositories\Eloquent\LocationViolationRepository;
use App\Models\UserLocation;
use Yajra\Datatables\Services\DataTable;

class UserLocationsDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables->eloquent($this->query())
	        ->addColumn('address', function($location) {
	        	if ( strlen($location->address) > 30 ) {
		        	return '<span title="'. $location->address .'">'. substr($location->address, 0, 30). '...</span>';
		        } else {
			        return $location->address;
		        }
	        })
	        ->addColumn('status', function($location) {
		        return $location->status();
	        })
	        ->addColumn('violations', function($location) {
		        if( $location->isPending() || $location->isRejected() ) {
			        return 'N/A';
		        }
		        if ( ($violations = LocationViolationRepository::instance()->getLocationViolations( $location->id )) && $violations->count() ) {
		        	return $violations->implode('title','<br>');
		        }
		        return 'No violation is reported';
	        })
	        ->addColumn(
                'created_at', function ( $job ) {
                return toolbox()->datetime()->formatShortDateTimeFormat( $job->created_at );
            })
            ->addColumn('action', function( $job ) {
                return '
                    <button type="button" class="btn bg-blue waves-effect btn-xs btn-view" title="View" data-id="'. $job->id .'">View</button>
                    <button type="button" class="btn btn-danger waves-effect btn-xs btn-delete" title="Delete" data-id="' . $job->id .'">Delete</button>
                ';
            })
        ->rawColumns(['action', 'address', 'violations'])
        ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
	    $query = UserLocation::join( 'users', 'user_locations.homeowner_id', '=', 'users.id' )
		    ->select(
			    'user_locations.id',
			    'address',
			    'street',
			    'city',
			    'zip',
			    'is_approved',
			    'user_locations.created_at'
		    )->where( 'homeowner_id', auth()->user()->id );

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
                    ->addAction(['width' => '75px'])
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
            'status',
            'violations',
            'created_at',
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
