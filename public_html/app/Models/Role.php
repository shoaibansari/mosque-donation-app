<?php namespace App\Models;

use App\Dashboard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
	const TYPE_ADMIN = 1;
	const TYPE_MOSQUE_ADMIN = 2;
	const TYPE_DONOR = 3;

	protected $fillable = ['title', 'active'];


	/**
	 * Active / Inactive
	 *
	 * @param $query
	 * @return mixed
	 */
	public function scopeActive( $query ) {
		return $query->where('active', 1);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users() {
		return $this->belongsToMany( User::class );
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function permissions() {
		return $this->belongsToMany( Permission::class, 'role_permissions' );
	}

}
