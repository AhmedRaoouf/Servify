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
        Schema::create('specialists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal('average_rating', 2, 1)->default(0);
            $table->text('description')->nullable();
            $table->integer('num_of_experience')->default(0);
            $table->integer('num_of_customers')->default(0);
            $table->integer('earning')->default(0);
            $table->json('personal_card')->nullable();
            $table->string('personal_image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialists');
    }
};
