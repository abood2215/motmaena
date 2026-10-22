<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['registration_id', 'course_key', 'name', 'subtitle', 'quote', 'rating', 'sort', 'is_active'];

    public function registration()
    {
        return $this->belongsTo(CourseRegistration::class);
    }

    protected $casts = ['is_active' => 'boolean'];
}
