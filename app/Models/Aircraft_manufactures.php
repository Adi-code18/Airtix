<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aircraft_manufactures extends Model
{
    protected $primaryKey = 'aircraft_manufacture_id';
    protected $fillable = ['name'];
}