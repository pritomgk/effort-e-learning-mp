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
            $table->integer('gender');
            $table->string('home_town')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('balance')->nullable();
            $table->unsignedBigInteger('parent_id');
            $table->string('user_code');
            $table->string('parent_user_code');
            $table->string('leader_user_code');
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('role_id')->on('user_roles');
            $table->integer('status')->default(0);
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


