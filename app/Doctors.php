<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctors extends Model
{
    protected $fillable = [
        'start_time',
        'end_time',
        'position',
        'description'
    ];
    protected $table = 'doctors';

    public function user() {
        return $this->belongsTo('App\User');
    }
}
