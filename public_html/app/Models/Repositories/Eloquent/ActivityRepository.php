<?php
/**
 * Created by Muhammad Adnan
 * Created Time: 11/20/2017 11:09 PM
 */

namespace App\Models\Repositories\Eloquent;

use App\Models\Activity;
use App\Models\Repositories\ActivityRepositoryInterface;

class ActivityRepository extends AbstractRepository implements ActivityRepositoryInterface {
	
	public function __construct(Activity $activity) {
		parent::__construct($activity);
		
	}
	
	private $actorId, $actorName, $actorLabel;
	private $action, $actionPhrase;
	//private $via, $viaId, $viaModelName, $viaLabel, $viaLink;
	private $itemModel, $itemModelId, $itemLabel, $itemPrefix, $itemLink;
	
	
	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return ActivityRepository|null
	 * @throws \Exception
	 */
	public static function instance($new = false, $attributes = []) {
		static $instance = null;
		if(is_null($instance) || $new) {
			$instance = new ActivityRepository((new Activity($attributes)));
			$instance->reset();
		}
		
		return $instance;
	}
	
	/**
	 * @throws \Exception
	 */
	public function reset() {
		$user = $this->getUser();
		$this->actor($user->id, $user->name);
		$this->action = $this->actionPhrase = null;
		$this->via = $this->viaId = $this->viaModelName = $this->viaLabel = $this->viaLink = null;
		$this->itemModel = $this->itemModelId = $this->itemLabel = $this->itemLink = null;
	}
	
	/**
	 * @param $id
	 * @param null $actorLabel
	 * @return $this
	 * @throws \Exception
	 */
	function actor( $id, $actorLabel=null ) {
		
		if ( !$user = $this->getUser($id) ) {
			throw new \Exception('Actor not found:' . $id);
		}
		
		$this->actorId = $id;
		if ( is_null($actorLabel) ) {
			$this->actorName = $this->actorLabel = $user->name;
		}
		else {
			$this->actorLabel = $actorLabel;
			$this->actorName = $user->name;
		}
		
		return $this;
	}
	
	public function action( $action, $phrase=null ) {
		$this->action = strtolower($action);
		$this->actionPhrase = $phrase;
		
		return $this;
	}

	
	public function item($modelName, $modelId, $label=null, $prefix=null, $link = null) {
		$this->itemModel = $modelName;
		$this->itemModelId = $modelId;
		$this->itemLabel = $label;
		$this->itemPrefix = is_null($prefix) ? $this->itemModel : $prefix;
		$this->itemLink = $link;
		
		return $this;
	}
	
	/**
	 * @return Activity
	 * @throws \Exception
	 */
	public function add() {
		$message[] = $this->getUserLink( $this->actorId, $this->actorLabel );
		$message[] = $this->getPhrase();
		$message[] = $this->getActionPhrase();
		$message = implode(" ", $message);
		$activity = $this->addRecord(
			[
				'module'  => $this->itemModel,
				'action'  => $this->action,
				'user_id' => $this->actorId,
				'user_name' => $this->actorName,
				'details' => $message
			]
		);
		$this->reset();
		return $activity;
	}
	
	/**
	 * @return string
	 */
	private function getPhrase() {
		$phrase[] = 'has';
		if ( $this->actionPhrase ) {
			$phrase[] = $this->actionPhrase;
		}
		else {
			$rephrase = '';
			switch ( $this->action ) {
				case 'create': $rephrase = 'created a'; break;
				case 'update': $rephrase = 'updated a'; break;
				case 'delete': $rephrase = 'deleted a'; break;
				case 'import': $rephrase = 'imported'; break;
				case 'upload': $rephrase = 'uploaded'; break;
			}
			$phrase[] = $rephrase;
		}
		
		return implode(' ', $phrase);
	}
	
	/**
	 * @return string
	 * @throws \Exception
	 */
	private function getActionPhrase() {
		
		if ( !is_null($this->itemLabel) ) {
			$label = $this->itemLabel;
		} else {
			$label = $this->itemModel;
		}
		
		if ( !is_null($this->itemLink) ) {
			$link = $this->itemLink;
		}
		else {
			switch( strtolower($this->itemModel) ) {
				case 'drive':
					if( $this->itemModelId ) {
						$link = route('admin.jobs.view', $this->itemModelId);
					}
					else {
						$link = route('admin.jobs.manage');
					}
					break;
				
				case 'hoa':
					if($this->itemModelId) {
						$link = route('admin.areas.edit', $this->itemModelId);
					}
					else {
						$link = route('admin.areas.manage');
					}
					break;
				
				case 'location_photo':
					if($this->itemModelId) {
						$link = route('admin.jobs.image', [$this->itemModelId['job_id'], $this->itemModelId['location_id'] ]);
					}
					else {
						$link = route('admin.jobs.manage');
					}
					break;
					
				case 'location_violation':
					if( $this->itemModelId ) {
						$link = route('admin.location.violation.view', $this->itemModelId );
					}
					else {
						$link = route('admin.location.violation.manage');
					}
					break;
				
				case 'driver':
					if($this->itemModelId) {
						$link = route('admin.vehicles.edit', $this->itemModelId);
					}
					else {
						$link = route('admin.vehicles.manage');
					}
					break;
				
				case 'camera':
					if($this->itemModelId) {
						$link = route('admin.cameras.edit', $this->itemModelId);
					}
					else {
						$link = route('admin.cameras.manage');
					}
					break;
				
				default:
					throw new \Exception('Model type not found: ' . $this->itemModel);
			}
		}
		
		return $this->itemPrefix . ' <a href="'. $link.'">'. $label .'</a>';
	}
	
	/**
	 * @param int $limit
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
	 */
	public function get( $limit=30 ) {
		return $this->model->orderBy('created_at', 'desc')->take( $limit )->get();
	}
	
	/**
	 * @param $user_id
	 * @param null $userLabel
	 * @return string
	 * @throws \Exception
	 */
	private function getUserLink( $user_id, $userLabel=null ) {
		$user = $this->getUser( $user_id );
		return '<a href="'. route('admin.users.edit', $user->id) .'">'. ($userLabel ? $userLabel : $user->name) .'</a>';
	}
	
	
	private function getUser( $user_id=null ) {
		
		if(is_null($user_id)) {
			$user = repo()->user()->getLoggedInUser();
		}
		else {
			$user = repo()->user()->findById($user_id);
		}
		
		if( !$user ) {
			throw new \Exception('Unknown user:' . $user_id);
		}
		
		return $user;
	}
}