<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'login_history';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'ip', 'country', 'login_via'];
}
