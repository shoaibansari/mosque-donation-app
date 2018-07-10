<?php

namespace App\DataTables\Backoffice;

use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Yajra\Datatables\Services\DataTable;
use Illuminate\Support\Facades\DB;

class UsersDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables->eloquent($this->query())
	        ->addColumn('blocked', function( $user ) {
		        if ( !$user->is_deleteable ) {
			        return "&mdash;";
		        }
                $checked = $user->is_blocked ? ' checked="" ' : '';
		        $disabled = $user->is_deleteable ? "" : ' disabled=""';
		        $switchColor = $user->is_deleteable ? " switch-col-red" : ' switch-col-disabled';
		        return '
	            <div class="switch">
                    <label><input type="checkbox" '. $checked .' value="1" data-id="'. $user->id .'" class="is-blocked" '. $disabled .'><span class="lever '. $switchColor .'"></span></label>
                </div>';
	        })
	        ->addColumn('confirmed', function( $user ) {

	        	// if user is not deleteable then no need to shown this option
	        	if ( !$user->is_deleteable ) {
	        		return "&mdash;";
		        }

		        // If user already confirmed then no need to show the button
		        if ( $user->is_confirmed ) {
	        		return "Yes";
		        }
                $checked = $user->is_confirmed ? ' checked="" ' : '';
		        $disabled = $user->is_deleteable ? "" : ' disabled=""';
		        $switchColor = $user->is_deleteable ? " switch-col-indigo" : ' switch-col-disabled';
		        return '
	            <div class="switch">
                    <label><input type="checkbox" '. $checked .' value="1" data-id="'. $user->id .'" class="is-confirmed" '. $disabled .'><span class="lever '. $switchColor .'"></span></label>
                </div>';
	        })
	        ->addColumn('action', function( $user ) {
		        $disabled = $user->is_deleteable ? "" : ' disabled=""';
		        return '
					<button type="button" class="btn bg-purple waves-effect btn-xs btn-edit" title="Edit" data-id="'. $user->id .'">Edit</button>
					<button type="button" class="btn btn-danger waves-effect btn-xs btn-delete" title="Delete" data-id="' . $user->id .'" '. $disabled .' >Delete</button>
				';
	        })
	        ->addColumn( 'last_login', function( $user ) {
	        	if ( !$user->last_login_at )
	        		return 'Never login';
	        	return toolbox()->datetime()->parse( $user->last_login_at )->diffForHumans();
	        })
	        ->addColumn( 'user_type', function($user) {
                
	        	if ( $user->isMosqueAdmin() ) {
	        	    return 'Mosque Admin';
		        }else if ( $user->isDonor() ) {
                    return 'Donor';
                }
                else {
			        return '<em>No role assigned.</em>';
		        }
	        
             })
        ->rawColumns(['blocked', 'confirmed', 'action'])
        ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = User::query()->where('id', '!=', User::ADMIN_ID )->orderBy('is_confirmed','asc');
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
            'name',
            'email',
            'user_type',
            'blocked',
            'confirmed',
            'last_login',
            
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
