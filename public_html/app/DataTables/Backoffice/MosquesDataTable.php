<?php

namespace App\DataTables\Backoffice;

use App\Models\Admin;
use App\Models\Role;
use App\Models\Mosque;
use Carbon\Carbon;
use Yajra\Datatables\Services\DataTable;
use Illuminate\Support\Facades\DB;

class MosquesDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function ajax()
    {
        return $this->datatables->eloquent( $this->query())
            ->addColumn('action', function( $mosque ) {
                return '
                    <button type="button" class="btn bg-purple waves-effect btn-xs btn-edit" title="Edit" data-id="'. $mosque->id .'">Edit</button>
                    <button type="button" class="btn btn-danger waves-effect btn-xs btn-delete" title="Delete" data-id="' . $mosque->id .'">Delete</button>
                ';
            })
            ->addColumn( 'is_active', function($mosque) {
                if ( $mosque->is_active == 1) {
                    return 'Yes';
                }else if ( $mosque->is_active == 0 ) {
                    return 'No';
                }
            })
        ->orderColumn('is_active', 'is_active $1')
        ->orderColumn('created_at', 'created_at $1')
        ->rawColumns(['is_active','action'])
        ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Mosque::query();
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
            'mosque_name',
            'address',
            'is_active' => ['title' => 'Active'],
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
