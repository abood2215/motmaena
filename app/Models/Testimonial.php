<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['name', 'subtitle', 'quote', 'rating', 'sort', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
