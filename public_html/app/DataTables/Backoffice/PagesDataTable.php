<?php

namespace App\DataTables\Backoffice;

use App\Models\Page;
use Yajra\Datatables\Services\DataTable;

class PagesDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables->eloquent($this->query())
	        ->addColumn('published', function($page) {
	        	// if not homepage
	        	if ( $page->id !== 1) {
	        		$checked = $page->published ? ' checked="" ' : '';
			        return '
		            <div class="switch">
	                    <label><input type="checkbox" '. $checked .' value="1" data-id="'. $page->id .'" class="publish-status"><span class="lever switch-col-indigo"></span></label>
	                </div>';
		        }
	        })
	        ->addColumn('action', function($page) {
		        return '
					<button type="button" class="btn bg-purple waves-effect btn-xs btn-edit" title="Edit" data-id="'. $page->id .'">Edit</button>
					<button type="button" class="btn bg-blue waves-effect btn-xs btn-browse" title="Browse" data-id="' . $page->id . '" data-url="'. $page->getUrl() .'" >Browse</button>
				';
	        })
        ->rawColumns(['published', 'action'])
        ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Page::query();
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
                    ->addAction(['width' => '150px'])
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
            'heading',
            'slug',
            'published',
            'published_at',
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
