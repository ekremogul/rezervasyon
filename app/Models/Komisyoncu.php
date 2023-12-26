<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komisyoncu extends Model
{
    protected $fillable = [
        'name',
        'details'
    ];

    protected $casts = [
        'details' => 'array'
    ];
}
