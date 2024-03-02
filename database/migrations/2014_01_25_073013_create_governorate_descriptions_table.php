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
        Schema::create('governorate_descriptions', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->foreignId('governorate_id')->constrained('governorates')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('country_id')->default(1)->constrained('countries')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('governorate_descriptions');
    }
};
