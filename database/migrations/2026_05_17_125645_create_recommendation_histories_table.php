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
        Schema::create('recommendation_histories', function (Blueprint $table) {
            $table->id();
            $table->string('criteria_undertone')->nullable();
            $table->string('criteria_lip_condition')->nullable();
            $table->string('criteria_finish')->nullable();
            $table->string('criteria_long_lasting')->nullable();
            $table->string('criteria_price_range')->nullable();
            $table->text('result_product_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommendation_histories');
    }
};
