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
        Schema::create('member_users', function (Blueprint $table) {
            $table->id('member_id');
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->integer('email_verified')->nullable();
            $table->string('verify_token')->nullable();
            $table->string('whatsapp')->unique();
            $table->string('gender');
            $table->string('home_town')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('balance')->nullable();
            $table->string('withdraws')->nullable();
            $table->string('user_code')->nullable();
            $table->string('parent_user_code')->nullable();
            $table->unsignedBigInteger('presenter_id')->nullable();
            $table->unsignedBigInteger('cp_id')->nullable();
            $table->unsignedBigInteger('executive_id')->nullable();
            $table->unsignedBigInteger('eo_id')->nullable();
            $table->unsignedBigInteger('seo_id')->nullable();
            $table->unsignedBigInteger('director_id')->nullable();
            $table->unsignedBigInteger('dg_id')->nullable();
            $table->integer('presenter_approval')->default(0);
            $table->integer('cp_approval')->default(0);
            $table->integer('executive_approval')->default(0);
            $table->integer('eo_approval')->default(0);
            $table->integer('seo_approval')->default(0);
            $table->integer('director_approval')->default(0);
            $table->integer('dg_approval')->default(0);
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('course_id')->on('courses');
            $table->unsignedBigInteger('role_id')->default(11);
            $table->foreign('role_id')->references('role_id')->on('user_roles');
            $table->integer('status')->default(0);
            $table->string('pro_pic')->nullable();
            $table->string('password');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_users');
    }
};


