<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_offers', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 60)->unique(); // used in /register/{slug}
            $table->string('title_ar', 150);
            $table->string('title_en', 150)->nullable();
            $table->string('trainer_ar', 120)->default('أ.د. طارق الحبيب');
            $table->string('trainer_en', 120)->nullable();
            $table->decimal('price', 10, 3);
            $table->date('date');
            $table->string('time_ar', 80)->nullable();
            $table->string('time_en', 80)->nullable();
            $table->string('location_ar', 200)->nullable();
            $table->string('location_en', 200)->nullable();
            $table->string('certificate_ar', 200)->nullable();
            $table->string('certificate_en', 200)->nullable();
            $table->text('topics_ar')->nullable(); // one topic per line
            $table->text('topics_en')->nullable();
            $table->string('image')->nullable();   // public path, falls back to the doctor photo
            $table->boolean('is_active')->default(true);   // registration open
            $table->boolean('is_featured')->default(false); // shown in the homepage banner
            $table->timestamps();
        });

        // Move the course that used to live in config/course_offers.php
        DB::table('course_offers')->insert([
            'slug'           => 'anger-management',
            'title_ar'       => 'دورة إدارة الغضب',
            'title_en'       => 'Anger Management Course',
            'trainer_ar'     => 'أ.د. طارق الحبيب',
            'trainer_en'     => 'Prof. Dr. Tariq Al-Habib',
            'price'          => 30,
            'date'           => '2026-10-28',
            'time_ar'        => '7:00 - 9:00 مساءً',
            'time_en'        => '7:00 - 9:00 PM',
            'location_ar'    => 'حضوري - الكويت، برج أحمد، بجوار المستشفى الأميري',
            'location_en'    => 'In-person - Kuwait, Burj Ahmed, near Al-Amiri Hospital',
            'certificate_ar' => 'شهادة معتمدة من ديوان الخدمة المدنية والتطبيقي',
            'certificate_en' => 'Certificate accredited by the Civil Service Commission & PAAET',
            'topics_ar'      => implode("\n", ['مفهوم الغضب وأنواعه', 'مراحل الغضب', 'أسباب الغضب', 'الخبرة المتكاملة الضابطة للغضب', 'أنماط التفكير السلبي المحفزة للغضب', 'استراتيجيات التعامل مع الغضب', 'دور الجانب الروحي في إدارة الغضب', 'برنامج التحكم في الغضب']),
            'topics_en'      => implode("\n", ['The concept and types of anger', 'Stages of anger', 'Causes of anger', 'An integrated approach to controlling anger', 'Negative thinking patterns that trigger anger', 'Strategies for dealing with anger', 'The spiritual side of anger management', 'Anger control program']),
            'is_active'      => true,
            'is_featured'    => true,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('course_offers');
    }
};
