<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Paid registrations are sent to the center's internal system (client file + check + invoice)
    public function up(): void
    {
        Schema::table('course_offers', function (Blueprint $table) {
            $table->string('center_course_code', 30)->nullable();
        });

        Schema::table('course_registrations', function (Blueprint $table) {
            $table->unsignedBigInteger('center_patient_id')->nullable();
            $table->unsignedBigInteger('center_rec_id')->nullable();
            $table->timestamp('center_synced_at')->nullable();
            $table->string('center_error', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('course_offers', fn (Blueprint $table) => $table->dropColumn('center_course_code'));
        Schema::table('course_registrations', fn (Blueprint $table) => $table->dropColumn(['center_patient_id', 'center_rec_id', 'center_synced_at', 'center_error']));
    }
};
