<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('course_key', 60)->index();
            $table->string('name', 120);
            $table->string('phone', 20);
            $table->string('email', 150)->nullable();
            $table->foreignId('discount_code_id')->nullable()->constrained()->nullOnDelete();
            $table->string('discount_code', 40)->nullable();
            $table->decimal('original_amount', 10, 3);
            $table->decimal('discount_amount', 10, 3)->default(0);
            $table->decimal('final_amount', 10, 3);
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('invoice_id', 40)->nullable()->index();
            $table->string('payment_id', 60)->nullable();
            $table->string('payment_method', 40)->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_registrations');
    }
};
