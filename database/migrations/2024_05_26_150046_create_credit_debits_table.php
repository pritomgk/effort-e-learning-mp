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
        Schema::create('credit_debits', function (Blueprint $table) {
            $table->id('cd_id');
            $table->string('name')->nullable();
            $table->string('amount')->nullable();
            $table->string('source')->nullable();
            $table->string('member_id')->nullable();
            $table->string('member_user_code')->nullable();
            $table->string('admin_id')->nullable();
            $table->string('admin_user_code')->nullable();
            $table->string('new_member_id')->nullable();
            $table->string('new_member_code')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_debits');
    }
};
