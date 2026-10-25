<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationBooking extends Model
{
    protected $fillable = ['phone', 'problem_type', 'notes', 'admin_notes', 'status', 'kind', 'name', 'mode', 'crm_task_id', 'crm_error'];
}
