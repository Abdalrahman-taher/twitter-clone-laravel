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
        Schema::create('likes', function (Blueprint $table) {

            $table->id();
            //{->constrained()} means that the id of the user must exist in the users table
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            //{->cascadeOnDelete()} means that if the user is deleted, the likes associated with that user will be deleted as well
            $table->foreignId('tweet_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
