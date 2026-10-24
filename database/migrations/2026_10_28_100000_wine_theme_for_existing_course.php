<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /** The new wine homepage: move the course still on the old default blue to the brand colour. */
    public function up(): void
    {
        DB::table('course_offers')->where('theme_color', '#1d4e89')->where('slug', 'anger-management')->update(['theme_color' => '#6d1b2b']);
    }

    public function down(): void
    {
        DB::table('course_offers')->where('theme_color', '#6d1b2b')->where('slug', 'anger-management')->update(['theme_color' => '#1d4e89']);
    }
};
