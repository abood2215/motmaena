<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Thursday appointment requests with Dr. Tariq live with the other consultation requests,
    // and are passed on to the call-center CRM (task + staff notification).
    public function up(): void
    {
        Schema::table('consultation_bookings', function (Blueprint $table) {
            $table->string('kind', 20)->default('general')->index();
            $table->string('name', 120)->nullable();
            $table->string('mode', 40)->nullable();
            $table->unsignedBigInteger('crm_task_id')->nullable();
            $table->string('crm_error', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('consultation_bookings', fn (Blueprint $table) => $table->dropColumn(['kind', 'name', 'mode', 'crm_task_id', 'crm_error']));
    }
};
