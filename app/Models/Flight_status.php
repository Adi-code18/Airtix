<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight_status extends Model
{
    protected $primaryKey = 'flight_status_id';
    protected $fillable = ['name'];

    public function flights()
    {
        return $this->hasMany(Flight::class, 'flight_status_id', 'flight_status_id');
    }
}