<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Real seat limit; null = unlimited
        Schema::table('course_offers', function (Blueprint $table) {
            $table->unsignedInteger('seats')->nullable()->after('price');
        });

        // "Notify me about the next course"
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120)->nullable();
            $table->string('phone', 20)->index();
            $table->string('course_key', 60)->nullable(); // set when they asked from a full/closed course
            $table->string('utm_source', 100)->nullable();
            $table->string('referrer', 255)->nullable();
            $table->timestamp('contacted_at')->nullable();
            $table->timestamps();
        });

        // Referral codes belong to the registration that earned them
        Schema::table('discount_codes', function (Blueprint $table) {
            $table->foreignId('owner_registration_id')->nullable()->after('course_key')
                ->constrained('course_registrations')->nullOnDelete();
        });

        // Personal review link per paid registration
        Schema::table('course_registrations', function (Blueprint $table) {
            $table->string('review_token', 40)->nullable()->unique()->after('followed_up_at');
            $table->timestamp('review_requested_at')->nullable()->after('review_token');
        });

        // Reviews submitted by trainees land here, hidden until approved
        Schema::table('testimonials', function (Blueprint $table) {
            $table->foreignId('registration_id')->nullable()->after('id')->constrained('course_registrations')->nullOnDelete();
            $table->string('course_key', 60)->nullable()->after('registration_id');
        });

        $now = now();
        foreach (['referral_discount_percent' => '10', 'referral_reward_kwd' => '5'] as $key => $value) {
            DB::table('site_settings')->updateOrInsert(['key' => $key], ['value' => $value, 'created_at' => $now, 'updated_at' => $now]);
        }
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropConstrainedForeignId('registration_id');
            $table->dropColumn('course_key');
        });
        Schema::table('course_registrations', function (Blueprint $table) {
            $table->dropUnique(['review_token']);
            $table->dropColumn(['review_token', 'review_requested_at']);
        });
        Schema::table('discount_codes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('owner_registration_id');
        });
        Schema::dropIfExists('leads');
        Schema::table('course_offers', function (Blueprint $table) {
            $table->dropColumn('seats');
        });
        DB::table('site_settings')->whereIn('key', ['referral_discount_percent', 'referral_reward_kwd'])->delete();
    }
};
