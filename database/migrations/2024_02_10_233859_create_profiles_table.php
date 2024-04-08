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
        Schema::create('profiles', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('full_name');
            $table->string('nickname')->unique();
            $table->string('phone_number',13);
            $table->integer('age');
            $table->enum('gender',['male','female']);
            $table->string('country');
            $table->string('address');
            $table->decimal('height', 5, 2);
            $table->decimal('width', 5, 2);
            $table->decimal('shoulder')->nullable();
            $table->decimal('chest')->nullable();
            $table->decimal('waist')->nullable();
            $table->decimal('hips')->nullable();
            $table->decimal('thigh')->nullable();
            $table->decimal('inseam')->nullable();
            $table->string('style')->nullable();
            $table->string('fav_brand')->nullable();
            $table->primary('user_id');
            $table->string('user_img')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
