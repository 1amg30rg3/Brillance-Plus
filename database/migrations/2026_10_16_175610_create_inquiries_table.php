<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 32);
            $table->string('preferred_language', 2);
            $table->string('property_type', 16);
            $table->string('service', 32);
            $table->string('package', 16)->nullable();
            $table->date('preferred_date')->nullable();
            $table->string('preferred_time_slot', 16)->nullable();
            $table->unsignedSmallInteger('property_size')->nullable();
            $table->unsignedTinyInteger('rooms')->nullable();
            $table->string('frequency', 16);
            $table->text('message')->nullable();
            $table->timestamp('privacy_consented_at');
            $table->timestamps();

            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
