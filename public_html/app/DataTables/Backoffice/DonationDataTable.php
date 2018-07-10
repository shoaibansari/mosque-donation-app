<?php

namespace App\DataTables\Backoffice;

use App\Models\Admin;
use App\Models\User;
use App\Models\Mosque;
use App\Models\Donation;
use Carbon\Carbon;
use Yajra\Datatables\Services\DataTable;
use Illuminate\Support\Facades\DB;

class DonationDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function ajax()
    {
        return $this->datatables->queryBuilder($this->query())
            ->addColumn('action', function( $donation ) {
                return '
                    <button type="button" class="btn bg-purple waves-effect btn-xs btn-edit" title="Edit" data-id="'. $donation->id .'">Edit</button>
                    <button type="button" class="btn btn-danger waves-effect btn-xs btn-delete" title="Delete" data-id="' . $donation->id .'">Delete</button>
                    <button type="button" class="btn btn-primary waves-effect btn-xs btn-view" title="View" data-id="' . $donation->id .'">View Funds</button>
                ';
            })
        ->rawColumns(['action'])
        ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {        
       $query = DB::table('donation_view');
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
                    ->addAction(['width' => '80px'])
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
            'name',
            'mosque',
            'title',
            'required_amount' => ['Title' => 'Required Amount'],
            'start_date' => ['title' => 'Start Date'],
            'end_date' => ['title' => 'End Date'],
            'created_at'=> ['title'=> 'Date Created'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'backoffice\donationsdatatables_' . time();
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
