<?php namespace App\Models;

use App\Notifications\Backoffice\AdminResetPasswordNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Reminder extends Model
{

    protected $table = 'password_resets';

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
    }




}
