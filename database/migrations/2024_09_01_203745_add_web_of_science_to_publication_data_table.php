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
        Schema::table('publication_data', function (Blueprint $table) {
            $table->string('web_of_science_link')->default('https://www.webofscience.com');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publication_data', function (Blueprint $table) {
            //
        });
    }
};
