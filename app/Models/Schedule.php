<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $primaryKey = 'schedule_id';
    protected $fillable = ['origin_data_airport_code', 'destination_data_airport_code', 'departure_time', 'arrival_time'];

    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
    ];

    public function flights()
    {
        return $this->hasMany(Flight::class, 'schedule_id', 'schedule_id');
    }

    public function origin_airport()
    {
        return $this->belongsTo(Airport::class, 'origin_data_airport_code', 'data_airport_code');
    }

    public function destination_airport()
    {
        return $this->belongsTo(Airport::class, 'destination_data_airport_code', 'data_airport_code');
    }
}
