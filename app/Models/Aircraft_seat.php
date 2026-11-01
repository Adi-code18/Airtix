<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aircraft_seat extends Model
{
    protected $fillable = ['aircraft_seat_id', 'travel_class_id'];
}