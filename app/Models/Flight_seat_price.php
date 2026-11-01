<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight_seat_price extends Model
{
    protected $fillable = ['flight_call', 'aircraft_id', 'seat_id', 'price'];
}