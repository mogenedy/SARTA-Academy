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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->decimal("price" , 9, 2);
            $table->text('description');
            $table->integer('online');
            $table->boolean('live');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string("duration");
            $table->string("certification")->nullable();
            $table->json('what_will_you_learn');
            $table->integer("level"); // 0 = beginner, 1 = intermediate, 2 = advanced
            $table->json('curriculam');
            $table->foreignId("category_id")->constrained()->cascadeOnDelete();
            $table->foreignId("institute_id")->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    // add category to course many to many relationship
     // Duration (number of hourse) static 3ade done
     // what will you learn as json description and multiplte points done
     // certification optinoal as string done
     // curriculam json or many to many done
     // course can have many instructors
     // level => beginner , intermediate , advanced done

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
