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
        Schema::create('osis_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position'); // e.g. Ketua OSIS, Wakil Ketua, Ketua Sekbid 1, Anggota
            $table->string('department')->default('bph'); // bph, sekbid_1, ..., sekbid_10, mpk
            $table->string('class_grade')->nullable(); // e.g. XI MIPA 2
            $table->string('photo')->nullable();
            $table->string('instagram')->nullable();
            $table->string('motto')->nullable();
            $table->integer('order_position')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('osis_members');
    }
};
