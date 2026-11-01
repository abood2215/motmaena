<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

// The center asked for one number for WhatsApp and calls everywhere on the site: +965 56551112.
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('site_settings')) return;

        SiteSetting::setMany(['whatsapp' => '96556551112', 'phone' => '96556551112']);
    }

    public function down(): void
    {
        SiteSetting::setMany(['whatsapp' => '96555665161', 'phone' => '96599880140']);
    }
};
