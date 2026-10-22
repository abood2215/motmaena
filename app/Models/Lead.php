<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = ['name', 'phone', 'course_key', 'utm_source', 'referrer', 'contacted_at'];

    protected $casts = ['contacted_at' => 'datetime'];
}
