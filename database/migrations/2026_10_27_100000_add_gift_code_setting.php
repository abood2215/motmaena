<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /** One fixed-amount gift code per registration paid without a code (replaces the friend/self choice). */
    public function up(): void
    {
        DB::table('site_settings')->updateOrInsert(['key' => 'gift_code_kwd'], ['value' => '10', 'created_at' => now(), 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('site_settings')->where('key', 'gift_code_kwd')->delete();
    }
};
