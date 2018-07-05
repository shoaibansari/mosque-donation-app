<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempFile extends Model
{
    protected $fillable = ['filename', 'saved_as', 'md5', 'size', 'mime', 'ext' ];
}
