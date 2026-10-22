<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 'referral' = shared with a friend, 'self' = the customer's own code for a next course
        Schema::table('discount_codes', function (Blueprint $table) {
            $table->string('kind', 20)->nullable()->after('owner_registration_id');
        });
        DB::table('discount_codes')->whereNotNull('owner_registration_id')->update(['kind' => 'referral']);

        DB::table('site_settings')->updateOrInsert(['key' => 'self_discount_percent'], ['value' => '10', 'created_at' => now(), 'updated_at' => now()]);
    }

    public function down(): void
    {
        Schema::table('discount_codes', function (Blueprint $table) {
            $table->dropColumn('kind');
        });
        DB::table('site_settings')->where('key', 'self_discount_percent')->delete();
    }
};
