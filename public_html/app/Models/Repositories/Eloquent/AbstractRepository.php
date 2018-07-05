<?php
namespace App\Models\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository {

	protected
		$model,
		$message,
		$errorCode,
		$errorMessage,
		$data;

	/**
	 * Create a new repository instance
	 * @param \Illuminate\Database\Eloquent\Model $model The model to execute queries on
	 */
	public function __construct( Model $model ) {
		$this->model = $model;
	}
	
	/**
	 * @param $field
	 * @param $value
	 * @return Model|null|static
	 */
	public function findBy($field, $value) {
		return $this->model->where( $field, $value)->first();
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function findById( $id ) {
		return $this->model->find( $id );
	}

	/**
	 * Ger repo model
	 *
	 * @param $idOrModel null
	 * @return Model
	 */
	public function getModel( $idOrModel = null ) {

		if ( is_scalar( $idOrModel ) ) {
			return $this->findById( $idOrModel );
		}

		if ( is_null( $idOrModel ) ) {
			return $this->model;
		}

		return $idOrModel;
	}

	/**
	 * Get a new modal instance
	 * @param  array $attributes
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function getNewModel( array $attributes = array() ) {
		return $this->model->newInstance( $attributes );
	}

	/**
	 * Create record
	 *
	 * @param $data
	 * @return mixed
	 */
	public function addRecord( $data ) {
		return $this->model->create( $data );
	}

	/**
	 * Update record
	 *
	 * @param $id
	 * @param $data
	 * @return mixed
	 */
	public function updateRecord( $id, $data ) {
		if ( !$record = $this->model->find( $id ) ) {
			$this->setErrorMessage( 'Unable to find record to update.' );

			return false;
		}

		return $this->model->find( $id )->update( $data );
	}

	/**
	 * Delete record
	 *
	 * @param $id
	 * @return mixed
	 */
	public function deleteRecord( $id ) {
		if ( !$record = $this->model->find( $id ) ) {
			$this->setErrorMessage( 'Unable to find record to delete.' );

			return false;
		}

		return $this->model->find( $id )->delete();
	}

	/**
	 * @param array $input
	 * @param null $active
	 * @return array
	 */
	public function getResultset( $input=[], $active=null ) {

		$page = isset( $input[ 'page' ] ) ? $input[ 'page' ] - 1 : 0;
		$perPage = isset( $input[ 'perPage' ] ) ? $input[ 'perPage' ] : 25;
		$sortColumn = isset( $input[ 'sortColumn' ] ) ? $input[ 'sortColumn' ] : 'id';
		$direction = isset( $input[ 'sortDirection' ] ) ? $input[ 'sortDirection' ] : 1;
		$direction = $direction ? 'desc' : 'asc';

		if ( isset($active) ) {
			if ( $active )
				$this->model = $this->model->active();
			else
				$this->model = $this->model->inactive();
		}

		//count all records
		$count = $this->model->count();

		if ( $page > 0 ) {
			$this->model = $this->model->skip( $page * $perPage );
		}

		if ( $perPage ) {
			$this->model = $this->model->take( $perPage );
		}

		$this->model = $this->model->orderBy( $sortColumn, $direction );

		return [
			'data'    => $this->model->get(),
			'count'   => $count,
			'perPage' => $perPage,
			'page'    => $page + 1
		];
	}

	/**
	 * Set data
	 *
	 * @param $key
	 * @param $value
	 */
	public function setData( $key, $value) {
		$this->data[ $key ] = $value;
	}

	/**
	 * Get data
	 *
	 * @param $key null
	 * @return mixed
	 */
	public function getData( $key=null ) {
		if ( !$this->data || !is_array($this->data) )
			return null;

		if ( is_null($key) ) {
			return $this->data;
		}

		if ( array_key_exists($key, $this->data) ) {
			return $this->data[ $key ];
		}

		return null;

	}

	/**
	 * Set message
	 *
	 * @param $message
	 * @return bool
	 */
	public function setMessage( $message ) {
		$this->message = $message;
		return true;
	}

	/**
	 * Get message
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * Set error message
	 *
	 * @param $message
	 * @param int $code
	 * @return boolean
	 */
	public function setErrorMessage( $message, $code = 503 ) {
		$this->errorMessage = $message;
		$this->errorCode = $code;
		return false;
	}

	/**
	 * Get error message
	 *
	 * @return mixed
	 */
	public function getErrorMessage() {
		return $this->errorMessage;
	}

	/**
	 * Get error code
	 * @return mixed
	 */
	public function getErrorCode() {
		return $this->errorCode;
	}

}
