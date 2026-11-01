<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aircraft_instance extends Model
{
    protected $primaryKey = 'aircraft_instance_id';
    protected $fillable = ['aircraft_id'];

    public function aircraft()
    {
        return $this->belongsTo(Aircraft::class, 'aircraft_id', 'aircraft_id');
    }
}