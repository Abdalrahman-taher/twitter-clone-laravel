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
        Schema::table('retweets', function (Blueprint $table) {

            // Quote Retweet text
            $table->text('body')->nullable()->after('tweet_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('retweets', function (Blueprint $table) {

            $table->dropColumn('body');

        });
    }
};
