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
        Schema::create('lands', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('broker_id')->nullable()->constrained('brokers')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->cascadeOnDelete();
            $table->foreignId('installment_id')->constrained('installments')->cascadeOnDelete();
            $table->foreignId('transaction_id')->constrained('transactions')->cascadeOnDelete();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->foreignId('water_id')->constrained('waters')->cascadeOnDelete();
            $table->foreignId('electricty_id')->constrained('electricities')->cascadeOnDelete();
            $table->string('governorate');
            $table->string('city');
            $table->string('district');
            $table->string('street');
            $table->string('locationGPS')->nullable();
            $table->string('facade')->nullable();
            $table->integer('propertyNum')->nullable();
            $table->text('description')->nullable();
            $table->integer('area');
            $table->integer('length');
            $table->integer('width');
            $table->string('ownerType')->nullable();
            $table->integer('totalPrice')->nullable();
            $table->integer('installmentPrice')->nullable();
            $table->integer('downPrice')->nullable();
            $table->integer('rentPrice')->nullable();
            $table->timestamp('creationDate')->nullable();
            $table->enum('status', ['active', 'notActive'])->default('notActive')->nullable();
            $table->enum('sale', ['sold', 'notSold'])->default('notSold')->nullable();
            $table->string('mainImage')->nullable();
            $table->json('image')->nullable();
            $table->string('video')->nullable();
            $table->string('audio')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lands');
    }
};
