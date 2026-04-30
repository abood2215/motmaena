<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationBooking extends Model
{
    protected $fillable = ['phone', 'problem_type', 'notes', 'status'];
}
