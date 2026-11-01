<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model
{
    protected $primaryKey = 'aircraft_id';
    protected $fillable = ['aircraft_manufacture_id', 'model'];

    public function manufacturer()
    {
        return $this->belongsTo(Aircraft_manufactures::class, 'aircraft_manufacture_id', 'aircraft_manufacture_id');
    }

    public function instances()
    {
        return $this->hasMany(Aircraft_instance::class, 'aircraft_id', 'aircraft_id');
    }
}