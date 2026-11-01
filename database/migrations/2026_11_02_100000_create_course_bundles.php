<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Course bundles ("both courses for 45 KWD"). Buying a bundle makes one registration per course,
     * paid together in one payment (bundle_group), each at its share of the bundle price — so seats,
     * attendee lists and the center system's checks stay per course. No discount codes, no gift code.
     */
    public function up(): void
    {
        Schema::create('course_bundles', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 60)->unique();
            $table->string('title_ar', 150);
            $table->string('title_en', 150)->nullable();
            $table->json('course_keys');            // course_offers.slug, in order
            $table->decimal('price', 10, 3);        // total for all the courses
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('course_registrations', function (Blueprint $table) {
            $table->string('bundle_key', 60)->nullable();
            $table->string('bundle_group', 40)->nullable()->index();
        });

        DB::table('course_bundles')->insert([
            'slug'        => 'november-courses',
            'title_ar'    => 'عرض دورتَي نوفمبر',
            'title_en'    => 'November two-course offer',
            'course_keys' => json_encode(['psychological-first-aid', 'communication-skills']),
            'price'       => 45,
            'is_active'   => true,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }

    public function down(): void
    {
        Schema::table('course_registrations', fn (Blueprint $table) => $table->dropColumn(['bundle_key', 'bundle_group']));
        Schema::dropIfExists('course_bundles');
    }
};
