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
        Schema::create('admin_users', function (Blueprint $table) {
            $table->id('admin_id');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('email_verified');
            $table->string('verify_token');
            $table->string('whatsapp')->unique();
            $table->integer('gender');
            $table->string('home_town');
            $table->string('city');
            $table->string('country');
            $table->string('balance');
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
        Schema::dropIfExists('admin_users');
    }
};
