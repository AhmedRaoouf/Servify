<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('country_descriptions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('country_id')->constrained('countries')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade')->onUpdate('cascade');

        });

        $this->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country_descriptions');
    }
    public function run(): void
    {
        DB::table('country_descriptions')->insert([
            ['name' => 'Egypt','language_id'=>1, 'country_id' => 1],
            ['name' => 'مصر', 'language_id'=>2, 'country_id'=>1],
        ]);
    }
};
