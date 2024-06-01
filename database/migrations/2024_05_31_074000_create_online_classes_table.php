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
        Schema::create('online_classes', function (Blueprint $table) {
            $table->id('class_id');
            $table->string('title');
            $table->string('class_date');
            $table->string('class_start_time');
            $table->string('class_end_time');
            $table->string('class_link');
            $table->unsignedBigInteger('course_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_classes');
    }
};


