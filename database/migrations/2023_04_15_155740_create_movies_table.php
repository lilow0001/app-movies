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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('original_language');
            $table->string('original_title');
            $table->string('overview',2000);
            $table->integer('popularity');
            $table->string('poster_path');
            $table->string('title');
            $table->integer('vote_average');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
