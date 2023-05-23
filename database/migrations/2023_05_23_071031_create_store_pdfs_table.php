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
        Schema::create('store_pdfs', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('fileName');
            $table->bigInteger('user_sub_id');
            $table->timestamps(false);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_pdfs');
    }
};