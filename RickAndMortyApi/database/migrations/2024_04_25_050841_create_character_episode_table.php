<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('character_episode', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('character_id');
            $table->unsignedBigInteger('episode_id');
            $table->timestamps();

            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->foreign('episode_id')->references('id')->on('episodes')->onDelete('cascade');

           // Unique key link if you want to prevent a character from appearing more than once in the same section.
            $table->unique(['character_id', 'episode_id'], 'character_episode_unique');
        });
    }

    public function down() {
        Schema::dropIfExists('character_episode');
    }
};