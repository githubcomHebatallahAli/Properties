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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('governorate');
            $table->string('center')->nullable();
            $table->string('address');
            $table->string('phoNum')->unique();
            $table->boolean('is_verified')->default(false);
            $table->timestamp('otp_sent_at')->nullable();
            $table->foreignId('role_id')->nullable()->constrained('roles')->cascadeOnDelete();
            $table->enum('status', ['active', 'notActive'])->default('active')->nullable();
            $table->string('photo')->nullable();
            $table->string('ip')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('last_logout_at')->nullable();
            $table->integer('session_duration')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }


};
