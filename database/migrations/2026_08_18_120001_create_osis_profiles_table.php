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
        Schema::create('osis_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('cabinet_name')->default('Kabinet Cakra Baskara');
            $table->string('period')->default('2025/2026');
            $table->string('tagline')->nullable()->default('Bersinergi, Berkarakter, Menginspirasi');
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->string('leader_name')->nullable()->default('Muhammad Rizky Pratama');
            $table->text('leader_welcome')->nullable();
            $table->string('leader_photo')->nullable();
            $table->string('cabinet_photo')->nullable();
            $table->string('cabinet_logo')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('osis_profiles');
    }
};
