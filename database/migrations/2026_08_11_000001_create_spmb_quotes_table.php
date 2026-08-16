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
        Schema::create('spmb_quotes', function (Blueprint $table) {
            $table->id();
            $table->text('quote_text');
            $table->string('author_source')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order_position')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spmb_quotes');
    }
};
