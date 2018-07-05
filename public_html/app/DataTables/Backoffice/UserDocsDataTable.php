<?php

namespace App\Backoffice\DataTables;

use App\Models\UserDoc;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Services\DataTable;

class UserDocsDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
    	return $this->datatables->eloquent($this->query())
	        ->addColumn('action', function( $userDoc) {
		        return '
					<button type="button" class="btn bg-blue waves-effect btn-xs btn-download" title="Browse" data-id="' . $userDoc->id . '" data-url="'. $userDoc->getFileUrl() .'" >Download</button>
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
        $query = UserDoc::query();
        $query->select(
        	'user_docs.id',
	        DB::raw('countries.title as country'),
	        'first_name',
	        'last_name',
	        'email',
	        'phone',
	        DB::raw('DATE_FORMAT(user_docs.updated_at,"%m/%d/%Y") as uploaded_at'),
	        'file_name'
	        //'user_docs.updated_at'
        )->join( 'countries', 'countries.id', '=', 'user_docs.country_id' );
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
            // add your columns
            'country_id' => 'country',
            'first_name',
            'last_name',
            'email',
            'phone',
            'created_at' => ['title' => 'Date Created'],
            //'updated_at' => ['title' => 'Last Update'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'userdocsdatatables_' . time();
    }
}
