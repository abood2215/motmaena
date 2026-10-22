<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_offers', function (Blueprint $table) {
            $table->string('theme_color', 7)->default('#1d4e89')->after('image'); // banner/frame colour
            $table->string('badge_ar', 80)->nullable()->after('theme_color');      // small label above the title
            $table->string('badge_en', 80)->nullable()->after('badge_ar');
            $table->boolean('show_installments')->default(true)->after('badge_en'); // "deema — 4 payments" pill
            $table->string('share_image')->nullable()->after('show_installments');  // WhatsApp/Instagram link preview
        });

        // The existing course already has a designed share image
        DB::table('course_offers')->where('slug', 'anger-management')->update(['share_image' => 'og-anger-management.jpg']);
    }

    public function down(): void
    {
        Schema::table('course_offers', function (Blueprint $table) {
            $table->dropColumn(['theme_color', 'badge_ar', 'badge_en', 'show_installments', 'share_image']);
        });
    }
};
