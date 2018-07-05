<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'login_attempts';


	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['ip', 'country', 'email', 'password'];
}
