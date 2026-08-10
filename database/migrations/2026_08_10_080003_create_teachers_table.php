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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 50)->nullable()->unique();
            $table->string('name');
            $table->string('title_prefix', 50)->nullable();
            $table->string('title_suffix', 50)->nullable();
            $table->string('subject');
            $table->enum('gender', ['L', 'P'])->default('L');
            $table->string('photo')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('education')->nullable();
            $table->integer('order_position')->default(0)->index();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
