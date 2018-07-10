<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MosqueDonation extends Model
{
    protected $table = 'funds';

    protected $fillable = [
        'user_id',
        'mosque_id',
        'donation_id',
        'email',
        'payment',
        'payment_method'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'funds');
    }

    public function mosques()
    {
        return $this->belongsTo(Mosque::class, 'mosque_id');
    }
}
