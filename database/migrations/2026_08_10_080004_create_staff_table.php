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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 50)->nullable()->unique();
            $table->string('name');
            $table->string('position');
            $table->enum('gender', ['L', 'P'])->default('L');
            $table->string('photo')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 50)->nullable();
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
        Schema::dropIfExists('staff');
    }
};
