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
        Schema::create('comments', function (Blueprint $table) {

            $table->id();

            // The user who wrote the comment
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // The tweet this comment belongs to
            $table->foreignId('tweet_id')
                ->constrained()
                ->cascadeOnDelete();

            // The comment text
            $table->text('body');

            $table->timestamps();

        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }





};
