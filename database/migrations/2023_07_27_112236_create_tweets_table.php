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
        Schema::create('tweets', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('snowflake_id')->unique();
            $table->string('lang')->default('en');
            $table->string('body')->nullable();
            $table->string('source')->nullable();
            $table->bigInteger('favorited')->default(0);
            $table->bigInteger('retweeted')->default(0);
            $table->boolean('truncated')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tweets');
    }
};
