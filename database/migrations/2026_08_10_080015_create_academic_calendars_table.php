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
        Schema::create('academic_calendars', function (Blueprint $table) {
            $table->id();
            $table->string('academic_year', 50)->index();
            $table->enum('semester', ['odd', 'even'])->default('odd');
            $table->string('title');
            $table->date('start_date')->index();
            $table->date('end_date')->nullable();
            $table->text('description')->nullable();
            $table->string('color_code', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_calendars');
    }
};
