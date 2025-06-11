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
        Schema::create('researcher_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('biography');
            $table->string('year_of_experience');
            $table->boolean('show_email');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('researcher_profiles');
    }
};
