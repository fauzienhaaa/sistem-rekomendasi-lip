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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand');
            $table->string('type'); // Lip Cream, Lip Tint, Lipstick, Lip Gloss
            $table->text('description');
            
            // Knowledge Base Attributes (Kriteria Pencocokan)
            $table->string('target_undertone'); // warm, cool, neutral
            $table->string('finish'); // matte, glossy, velvet
            $table->string('lip_condition'); // dry, normal, dark_lips
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
