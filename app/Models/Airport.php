<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    protected $primaryKey = 'data_airport_code';
    protected $keyType = 'string';
    protected $fillable = ['data_airport_code', 'name', 'city', 'data_country_code'];

    public function origin_schedules()
    {
        return $this->hasMany(Schedule::class, 'origin_data_airport_code', 'data_airport_code');
    }

    public function destination_schedules()
    {
        return $this->hasMany(Schedule::class, 'destination_data_airport_code', 'data_airport_code');
    }
}
