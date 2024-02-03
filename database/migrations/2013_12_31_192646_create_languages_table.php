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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('local');
            $table->string('name');
            $table->softDeletes();
        });

        $this->run(); // Call the run method after creating the table
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }

    public function run(): void
    {
        DB::table('languages')->insert([
            ['local' => 'en','name' => 'English'],
            ['local' => 'ar','name' => 'العربية'],
        ]);
    }
};
