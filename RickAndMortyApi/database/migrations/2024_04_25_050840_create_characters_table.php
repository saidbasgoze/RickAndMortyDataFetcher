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
        if (!Schema::hasTable('characters')) {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('status');
            $table->string('species');
            $table->string('type')->nullable();  
            $table->string('gender');
            $table->string('image')->nullable();  
            $table->timestamp('created')->nullable();  
            $table->unsignedBigInteger('origin_id')->nullable();  //Where it comes from
            $table->unsignedBigInteger('location_id')->nullable();  // Last location
            $table->timestamps();

            // Foreign keys
            $table->foreign('origin_id')->references('id')->on('locations')->onDelete('set null');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};