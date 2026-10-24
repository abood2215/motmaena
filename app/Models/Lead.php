<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    /** course_key used for people waiting for the psychological center to open */
    public const PSYCH_CENTER = 'psych-center';

    /** Labels for lead interests that aren't courses */
    public const EXTRA_TITLES = [self::PSYCH_CENTER => '🧠 المركز النفسي (قريباً)'];

    protected $fillable = ['name', 'phone', 'course_key', 'utm_source', 'referrer', 'contacted_at'];

    protected $casts = ['contacted_at' => 'datetime'];
}
