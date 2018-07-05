<?php 
namespace App\Models\Repositories\Eloquent;

use App\Models\ContactUs;
use App\Models\Repositories\ContactUsRepositoryInterface;

class ContactUsRepository extends AbstractRepository implements ContactUsRepositoryInterface
{
	/**
	 * ContactUsRepository constructor.
	 * @param ContactUs $contactUs
	 */
    public function __construct(ContactUs $contactUs)
    {
    	parent::__construct( $contactUs );
    }

	/**
	 * @param array $where
	 * @param array $columns
	 * @return mixed
	 */
    public function getAllRecords($where = [], $columns = [])
    {
        return $this->model->where($where)->where('active', 1)->get($columns);
    }



}
