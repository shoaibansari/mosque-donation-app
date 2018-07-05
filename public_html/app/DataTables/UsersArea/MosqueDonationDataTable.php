<?php

namespace App\DataTables\UsersArea;

use App\Models\Admin;
use App\Models\Donation;
use App\Models\Mosque;
use App\Models\MosqueDonation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Services\DataTable;

class MosqueDonationDataTable extends DataTable
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
            ->addColumn('user_id', function( $donation ) {
                 if($user = User::where('id',$donation->user_id)->first()){
                    return $user->name;
                }else{
                    return 'No user' ;
                }
            })
            ->addColumn('mosque_id', function( $donation ) {

                if($mosque = Mosque::where('id',$donation->mosque_id)->first()){
                    return $mosque->mosque_name;
                }else{
                    return 'No Mosque' ;
                }
            })
            ->addColumn('donation_id', function( $donation ) {
                if($donation = Donation::where('id',$donation->donation_id)->first()){
                    return $donation->donation_title;
                }else{
                    return 'No title' ;
                }
            })            
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
            'user_id' => ['title' => 'Name'],
            'mosque_id'=>['title' => 'Mosque'],
            'donation_id'=> ['title' => 'Donation'],
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
