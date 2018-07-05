<?php
namespace App\Models\Repositories\Eloquent;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Input;
use App\Models\Log;
use App\Models\Repositories\LogRepositoryInterface;
use yajra\Datatables\Datatables;

class LogRepository extends AbstractRepository implements LogRepositoryInterface
{

    /**
     * Construct of a class
     * @param Log $log   [description]
     */
    public function __construct(Log $log)
    {
        parent::__construct( $log );
    }

    /**
     * Get All Records
     * @return array return all data
     */
    public function getAll()
    {
        $inputs = Input::all();
        return $this->getAllResults($inputs);
    }

    /**
     * Get All Results
     * @param  array $inputs [description]
     * @return array         [description]
     */
    public function getAllResults($inputs)
    {
        $perPage = isset($inputs['per_page']) ? $inputs['per_page'] : 10;
        $page    = isset($inputs['page']) ? $inputs['page'] : 1;

        $from = $inputs['from'] ? $inputs['from'] : date('Y-m-d', strtotime('-90 days'));
        $to   = $inputs['to'] ? $inputs['to'] : date('Y-m-d');

        $interval = date_diff(date_create($from), date_create($to));
        $dateDiff = $interval->format('%a');

        if ($dateDiff <= 90) {
            $from = date('Y-m-d', strtotime($from));
            $to   = date('Y-m-d', strtotime($to));
        } else {
            $from = date('Y-m-d', strtotime('-90 days'));
            $to   = date('Y-m-d');
        }

        $log = $this->model
            ->where('user_id', $inputs['user_id'])
            ->where(function ($query) use ($from, $to) {
                $query->whereRaw('DATE(logs.created_at) >= \'' . $from . '\' AND DATE(logs.created_at) <= \'' . $to . '\'');
            });

        if ($page > 0 && $perPage > 0) {
            $log = $log->skip(($page - 1) * $perPage)->take($perPage);
        }

        $results['count']   = $log->count();
        $log->orderBy('id', 'DESC');

        $results['log']     = $log->get();
        $results['perPage'] = $perPage;
        $results['page']    = $page;

        return $results;
    }

    /**
     * Creates admin grid
     * @return Datatables
     */
    public function getData()
    {
        $start_date = Input::get('start_date');
        $end_date   = Input::get('end_date');

        if ($start_date && $end_date) {
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date   = date('Y-m-d', strtotime($end_date));
        }

        $data = $this->model;

        if (Auth::user()->user_type_id != 1) {
            $data = $data
                ->where('user_id', Auth::user()->id);
        }

        $data = $data
            ->leftJoin('users', 'users.id', '=', 'logs.user_id')
            ->where(function ($query) use ($start_date, $end_date) {
                if ($start_date && $end_date) {
                    $query->whereRaw('DATE(logs.created_at) >= \'' . $start_date . '\' AND DATE(logs.created_at) <= \'' . $end_date . '\'');
                }
            })
            ->get(
                [
                    DB::raw('Concat (users.first_name, " ", users.last_name) AS user_name'),
                    'logs.smart_coins',
                    'logs.type',
                    'logs.created_at',
                ]
            );

        return Datatables::of($data)
            ->editColumn('user_name', '{{ $user_name }}')
            ->editColumn('smart_coins', '{{ $smart_coins }}')
            ->editColumn('type', '{{ $type }}')
            ->editColumn('created_at', '{{ $created_at }}')
            ->make(true);
    }

    /**
     * Add data
     * @param  array $data
     * @return array
     */
    public function addLog($data)
    {
        return $this->model->create($data);
    }
}
