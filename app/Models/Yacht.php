<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Yacht extends Model
{
    protected $fillable = [
        'name',
        'hourly_price',
        'details'
    ];
}
