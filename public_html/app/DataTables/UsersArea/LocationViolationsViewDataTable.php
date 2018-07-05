<?php
namespace App\DataTables\UsersArea;
use App\Models\LocationViolation;
use Yajra\Datatables\Services\DataTable;

class LocationViolationsViewDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables->eloquent($this->query())
            ->addColumn('violation', function ( $lv ) {
                return '<a href="'. route('location.violation.details', $lv->id ) .'">' . $lv->violation->title . '</a>';
            })
            ->addColumn('reporter', function ( $lv ) {
                return $lv->reporter->name;
            })
	        ->addColumn('created_at', function ( $lv ) {
                return toolbox()->datetime()->parse( $lv->created_at )->diffForHumans();
            })
	        ->addColumn('updated_at', function ( $lv ) {
                return toolbox()->datetime()->parse( $lv->updated_at )->diffForHumans();
            })
            ->addColumn('action', function( $lv ) {
                return '
                    <button type="button" class="btn bg-blue waves-effect btn-xs btn-view" title="View" data-id="'. $lv->id .'">See Details</button>
                ';
            })
            ->rawColumns(['action', 'violation'])
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = LocationViolation::query( )
		    ->where('location_id', $this->request()->route( 'location_id' ))
	        ->whereHas('location', function($query) {
	        	$query->homeowner_id = auth()->user()->id;
	        });
	    ;
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
//                    ->addAction(['width' => '75px'])
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
            'violation',
            'reporter',
            'updated_at',
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
