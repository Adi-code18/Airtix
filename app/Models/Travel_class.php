<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Travel_class extends Model
{
    protected $primaryKey = 'travel_class_id';
    protected $fillable = ['name', 'description'];
}