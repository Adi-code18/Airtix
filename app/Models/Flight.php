<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $fillable = ['flight_call', 'schedule_id', 'flight_status_id', 'aircraft_instance_id'];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'schedule_id');
    }

    public function flight_status()
    {
        return $this->belongsTo(Flight_status::class, 'flight_status_id');
    }

    public function aircraft_instance()
    {
        return $this->belongsTo(Aircraft_instance::class);
    }
}
