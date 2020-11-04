<?php

namespace App;

use Rinvex\Bookings\Models\BookableBooking;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{


    /**
     * Поиск по slug
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $fillable = [
        'title', 'reg_day', 'start_date', 'end_date','doctor_id','user_id'
    ];

    /**
     *
     * Пользователь может иметь много записей
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users() {
        return $this->belongsTo('App\User');
    }
}