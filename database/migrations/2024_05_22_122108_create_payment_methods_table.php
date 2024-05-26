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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id('method_id');
            $table->string('name');
            $table->string('account_num');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('admin_id')->references('admin_id')->on('admin_users');
            $table->unsignedBigInteger('member_id')->nullable();
            $table->foreign('member_id')->references('member_id')->on('member_users');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};


