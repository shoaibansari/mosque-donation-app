<?php

namespace App\DataTables\UsersArea;

use App\Models\Admin;
use App\Models\MosqueDonation;
use App\Models\Mosque;
use App\Models\User;
use Carbon\Carbon;
use Yajra\Datatables\Services\DataTable;
use Illuminate\Support\Facades\DB;

class MosqueDonationUsersDataTable extends DataTable
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
            ->addColumn('action', function( $donation ) {
                return '
                    <button type="button" class="btn bg-purple waves-effect btn-xs btn-edit" title="Edit" data-id="'. $donation->id .'">Edit</button>
                    <button type="button" class="btn btn-danger waves-effect btn-xs btn-delete" title="Delete" data-id="' . $donation->id .'">Delete</button>
                ';
            })
            ->addColumn('user_id', function( $donation ) {
                return User::where('id',$donation->user_id);
            })
            ->addColumn('mosque_id', function( $donation ) {
                return Mosque::where('id',$donation->mosque_id);
            })
            
        //->orderColumn('is_active', 'is_active $1')

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
        $query = MosqueDonation::where('donation_id', request()->route('id') );
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
            'user_id'=>['title' => 'Name'],
            'mosque_id'=>['title' => 'Mosque'],
            'donation_id'=>['title' => 'Donation'],
            'email' => ['title' => 'Email'],
            'payment'=> ['title'=> 'payment'],
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
