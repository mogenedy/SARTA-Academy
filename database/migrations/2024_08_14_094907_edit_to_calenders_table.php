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
        Schema::table('calenders', function (Blueprint $table) {
            $table->renameColumn('event_name' , 'title');
            $table->renameColumn('date' , 'starts_at');
            $table->dateTime('ends_at');
            $table->nullableMorphs('calenderable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calenders', function (Blueprint $table) {
            //
        });
    }
};
