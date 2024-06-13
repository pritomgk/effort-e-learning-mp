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
        Schema::create('passbooks', function (Blueprint $table) {
            $table->id('record_id');
            $table->string('sender_name')->nullable();
            $table->string('receiver_name')->nullable();
            $table->unsignedBigInteger('sender_member_id')->nullable();
            $table->unsignedBigInteger('sender_admin_id')->nullable();
            $table->unsignedBigInteger('receiver_member_id')->nullable();
            $table->unsignedBigInteger('receiver_admin_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('sender_user_code')->nullable();
            $table->string('receiver_user_code')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passbooks');
    }
};
