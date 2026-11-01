<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $primaryKey = 'client_id';
    protected $fillable = ['first_name', 'middle_name', 'last_name', 'email', 'phone', 'passport', 'data_country_code'];
}